<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Exceptions\CouponCodeUnavailableException;
use App\Exceptions\InvalidRequestException;
use App\Handlers\DocxConversionHandler;
use App\Handlers\FileUploadHandler;
use App\Handlers\FileWordsHandle;
use App\Handlers\OrderApiHandler;
use App\Handlers\OrderimgHandler;
use App\Handlers\WordHandler;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Jobs\CheckOrderStatus;
use App\Jobs\FileWords;
use App\Jobs\OrderCheckedMsg;
use App\Jobs\OrderPendingMsg;
use App\Mail\OrderReport;
use App\Models\Category;
use App\Models\CouponCode;
use App\Models\Order;
use App\Services\OrderService;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class OrdersController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('category:id,name')->latest()->paginate(20);
        return view('orders.index', compact('orders'));
    }

    public function store(OrderRequest $request)
    {
        $order = $this->orderService->add($request);
        return new OrderResource($order);
    }

    public function show(Request $request, Order $order)
    {
        // 校验权限
        $this->authorize('own', $order);
        $user = $request->user();
//        $coupon_codes = $user->couponCodes()
//            ->with('category')
//            ->whereIn('type', [CouponCode::TYPE_FIXED, CouponCode::TYPE_PERCENT])
//            ->where('status', CouponCode::STATUS_ACTIVED)
//            ->get();
        return view('orders.show', compact('order'));
    }


    public function viewReport(Order $order, OrderApiHandler $apiHandler)
    {
        //校验权限
        $this->authorize('own', $order);
        $pdf = $apiHandler->extractReportPdf($order->api_orderid);
        return view('orders.view_report', compact('order', 'pdf'));
    }

    public function destroy(Request $request)
    {
        if(!is_array($request->ids)) {
            $ids = [$request->ids];
        }
        $ids = $request->ids;
        Order::whereIn('id', $ids)->delete();
        return [];
    }

    public function download($orderid)
    {
        if(strlen($orderid) == 3) {
            $order = Order::findOrFail($orderid);
        } else {
            $order = Order::where('orderid', $orderid)->first();
        }
        // 校验权限
//        $this->authorize('own', $order);
        if($order->report_path == '') {
            throw new InvalidRequestException('检测未完成', 400);
        }
//        if($order->pay_type == '百度支付') {
//            return response()->download('/storage/app/' . $order->report_path, $order->writer . '-' . $order->title . '.zip');
//        }
        return Storage::disk('downloads')->download($order->report_path, $order->writer . '-' . $order->title . '.zip');
//        return response()->download(storage_path() . '/app/' . $order->report_path, $order->writer . '-' . $order->title . '.zip');
    }

    public function generateQrcode(Request $request, Order $order)
    {
        if($request->rate) {
            $rate = $request->rate;
        } else {
            $rate = $order->rate;
        }
        //把要转换的字符串作为QrCode的构造函数
        $qrCode = new QrCode(url("/qcrode/generate_img?title={$order->title}&&writer={$order->writer}&&category_name={$order->category->name}&&classid={$order->category->classid}&&created_at={$order->created_at}&&rate={$rate}"));
        //将生成的二维码图片数据以字符串形式输出，并带上相应的响应类型
        return response($qrCode->writeString(), 200, ['Content-Type' => $qrCode->getContentType()]);
    }

    public function generateImg(Request $request)
    {
        $orderimg = app(OrderimgHandler::class);
        $img_url = $orderimg->generate($request->title, $request->writer, $request->category_name, $request->classid, $request->created_at, $request->rate);
        return view('orders.qrcode.index', compact('img_url'));
    }
}
