<?php

namespace App\Admin\Controllers;


use App\Admin\Actions\BatchQueue;
use App\Admin\Actions\Grid\ResetOrderStatus;
use App\Admin\Actions\Grid\UploadOrderFile;
use App\Admin\Actions\OrderBatchDelete;
use App\Admin\Forms\CreateCouponCode;
use App\Admin\Forms\OrderEdit;
use App\Handlers\FileUploadHandler;
use App\Jobs\getOrderStatus;
use App\Jobs\UploadCheckFile;
use App\Models\Order;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Color;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class OrderController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('订单列表')
            ->body($this->grid());
    }

    protected function grid()
    {
        // 第二个参数为 `Column` 对象， 第三个参数是自定义参数

        return Grid::make(Order::with(['category', 'user']), function(Grid $grid) {
            $grid->id->sortable()->display(function($id) {
                return "<span >$id</span>";
            })->downloadable("orders/{$this->id}/download_report");
            $grid->paginate(20);
            $grid->export()->disableExportAll();
            $grid->quickSearch('title', 'orderid', 'api_orderid', 'userid');
            $grid->selector(function(Grid\Tools\Selector $selector) {
                $selector->select('status', '状态', [
                    0 => '未支付',
                    1 => '待检测',
                    2 => '排队中',
                    3 => '检测中',
                    4 => '检测完成',
                    5 => '暂停',
                    6 => '取消',
                    7 => '已退款',
                ]);
                $selector->select('pay_price', '支付价格', ['0-99', '100-199', '200-299'], function($query, $value) {
                    $between = [
                        [0, 99],
                        [100, 199],
                        [200, 299],
                    ];

                    $value = current($value);

                    $query->whereBetween('pay_price', $between[$value]);
                });
            });

            $grid->model()->orderBy('created_at', 'desc');
            $grid->column('category.name', '系统');
            // 展示关联关系的字段时，使用 column 方法
            $grid->column('userid', '买家')->display(function($userid) {
                return User::find($userid)->phone ?? $this->userid;
            });
            $grid->column('status', '状态')->using([
                0 => '未支付',
                1 => '待检测',
                2 => '排队中',
                3 => '检测中',
                4 => '检测完成',
                5 => '暂停',
                6 => '取消',
                7 => '已退款',
            ])->dot([
                0 => 'danger',
                1 => Admin::color()->info(),
                2 => 'primary',
                3 => 'warning',
                4 => 'success',
                5 => Admin::color()->link(),
                6 => Admin::color()->cyanDarker(),
                7 => Admin::color()->blue(),
            ]);
//            $grid->column('title', '标题')->link(function($title) {
//                return admin_url('/orders/' . $this->id . '/edit');
//            })->copyable();
            $grid->column('title', '标题')->copyable()->modal('订单修改', OrderEdit::make());
//            $grid->model()->sum("pay_price");
            $grid->column('writer', '作者')->width('100px');
            $grid->column('words', '字数')->width('50px');
            $grid->column('pay_price', '支付金额')->width('100px');
            $grid->footer(function($collection) {
                // 查出统计数据
                $data = Order::all()->sum('pay_price');
                return "<div style='padding: 10px; color: red'>总收入 ： $data 元</div>";
            });
//            $grid->column('from', '来源');
            $grid->from('来源');
            $grid->referer('来路');
            $grid->keyword('关键字');
            $grid->created_at('创建时间')->sortable();

            $grid->actions(function(Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableView();

                // 禁用
                $actions->disableEdit();
                $actions->disableQuickEdit();
            });
            $grid->batchActions(function($batch) {
                $batch->add(new BatchQueue('批量启动队列'));
                $batch->add(new OrderBatchDelete());
            });
            // 禁用批量删除按钮
            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->filter(function($filter) {
//                $filter->panel();
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->like('title', '标题');
                $filter->like('writer', '作者');
                $filter->like('orderid', '订单号');
                $filter->like('api_orderid', 'api订单ID');
                $filter->like('from', '来源');
                $filter->equal('userid', '用户id');
                $filter->where('phone', function($query) {

                    $query->whereHas('user', function($query) {
                        $query->where('phone', 'like', "%{$this->input}%");
                    });

                }, '手机号');
                $filter->where('name', function($query) {

                    $query->whereHas('category', function($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });

                }, '检测系统');
                $filter->scope('1', '已支付')->where('status', 1);
                $filter->scope('3', '检测中')->where('status', 3);
                $filter->scope('4', '检测完成')->where('status', 4);
                $filter->scope('0', '未支付')->where('status', 0);
            });
        });
    }

    // 异步加载弹窗内容
    protected function modal()
    {
        return Modal::make()
            ->lg()
            ->delay(300) // loading 效果延迟时间设置长一些，否则图表可能显示不出来
            ->title('批量生成')
            ->body(CreateCouponCode::make())
            ->button('<button class="btn btn-white"><i class="feather icon-bar-chart-2"></i> 批量生成</button>');
    }

    public function edit($id, Content $content)
    {
        return $content->body(view('admin.orders.edit', ['order' => Order::find($id)]));
    }

    public function receved($id, Request $request)
    {
        $order = Order::findOrFail($id);
        $data = $request->all();
        $report_path = '';
        if($request->hasFile('file')) {
            $file = $request->file('file');
            if(!$file->isValid()) {
                abort(400, '无效的上传文件');
            }
            $path = 'downloads/report-' . $order->api_orderid . '.zip';
            \Storage::delete($path);
            $result = \Storage::putFileAs('downloads', $file, 'report-' . $order->api_orderid . '.zip');
            if($result) {
                $report_path = $path;
            }
        }
        $order->update([
            'status' => $data['status'],
            'rate' => $data['rate'],
            'report_path' => $report_path
        ]);
        if($order->status == 3) {
            dispatch(new getOrderStatus($order));
        } elseif($order->status == 1) {
            dispatch(new UploadCheckFile($order));
        }
        return response([
            'status' => 200,
            'data' => $order,
            'message' => '修改成功!',
            'redirect' => '/admin/orders'
        ]);
    }

    public function uploadPdf(Request $request, Order $order)
    {
        $file = $request->file;
        if(!$file->isValid()) {
            abort(400, '无效的上传文件');
        }
        $ext = $file->getClientOrginalExtension();
        $upload_path = public_path() . '/' . $extension;
        $filename = $order->orderid . '.' . $extension;
        //将文件移动到目标存储路径中
        $file->move($upload_path, $filename);
        return [
            'path' => config('app.url') . "/$extension/$filename",
        ];
    }

    public function uploadZip(Request $request)
    {
        dd($request->report_path);
        if($request->hasFile('file')) {
            $file = $request->file('file');
            if(!$file->isValid()) {
                abort(400, '无效的上传文件');
            }
            $path = 'downloads/report-' . $order->api_orderid . '.zip';
            \Storage::delete($path);
            $result = \Storage::putFileAs('downloads', $file, 'report-' . $order->api_orderid . '.zip');
            if($result) {
                return $path;
            }
        }
    }

    public function downloadPaper(Order $order)
    {
        if(!$order->paper_path) {
            abort(400, '无效的上传文件');
            return admin_error('标题', '没有文件!');
        }
        return response()->download($order->paper_path);
    }

    public function downloadReport(Order $order)
    {
//        return \Storage::download(storage_path() . '/app/' . $order->report_path);
        if(!$order->report_path) {
            return admin_error('错误!', '订单支付后才能下载论文');
        }
        return Storage::disk('downloads')->download($order->report_path ?? '', $order->writer . '-' . $order->title . '.zip');
//        return response()->download(storage_path() . '/app/' . $order->report_path, $order->writer . '-' . $order->title . '.zip');
    }
}
