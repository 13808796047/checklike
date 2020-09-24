<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderPaid;
use App\Exceptions\InvalidRequestException;
use App\Handlers\FileUploadHandler;
use App\Handlers\FileWordsHandle;
use App\Handlers\OrderApiHandler;
use App\Handlers\OrderimgHandler;
use App\Handlers\WordHandler;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Jobs\CheckOrderStatus;
use App\Mail\OrderReport;
use App\Models\Category;
use App\Models\Order;
use App\Services\OrderService;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use mysql_xdevapi\Exception;
use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class OrdersController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

//    //上传文件
//    public function uploadFile(Request $request, FileUploadHandler $fileUploadHandler)
//    {
//        //初始化上传返回数据,默认是失败的
//        $data = [
//            'success' => false,
//            'msg' => '上传失败!',
//            'file_path' => '',
//        ];
//        //判断是否有上传文件,并赋值给file
//        if($file = $request->file) {
//            // 保存文件到本地
//            $result = $fileUploadHandler->save($file, 'files', $user->id);
//            // 文件保存成功
//            if($result) {
//                $data['file_path'] = $result['path'];
//                $data['msg'] = '上传成功!';
//                $data['success'] = true;
//            }
//        }
//        return $data;
//    }

    //提交订单
    public function store(OrderRequest $request)
    {
        $order = $this->orderService->add($request);
        return new OrderResource($order);
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('category:id,name')->latest()->get();;
        return OrderResource::collection($orders);
    }

    public function show(Request $request, Order $order)
    {
        //        校验权限
        $this->authorize('own', $order);
        return new OrderResource($order);
    }

    public function viewPdf(Request $request)
    {

        //接口返回 pdf 流
        $order = Order::where('orderid', $request->orderid)->first();
        //校验权限
        $this->authorize('own', $order);
        $pdf = $this->orderService->getPdf($order->api_orderid);
        return $pdf;
    }

    public function destroy(Request $request)
    {
        if(!is_array($request->ids)) {
            $ids = [$request->ids];
        }
        $ids = $request->ids;
        Order::whereIn('id', $ids)->delete();
        return response()->json([
            'message' => '删除成功!'
        ]);
    }

    public function reportMail(Request $request, Order $order)
    {
        //校验权限
        $this->authorize('own', $order);
        $to = $request->email_address;
        //发送
        try {
            Mail::to($to)->send(new OrderReport($order));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'message' => '邮件发送成功,请注意查收！'
        ]);
    }

    public function generateImg(Request $request)
    {
        $orderimg = app(OrderimgHandler::class);
        $img_url = $orderimg->generate($request->title, $request->writer, $request->category_name, $request->classid, $request->created_at, $request->rate);
        return response(compact('img_url'), 200);
    }
}
