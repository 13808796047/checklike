<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
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
        $orders = $request->user()->orders()->with('category:id,name')->latest()->paginate(10);
        return view('domained::orders.index', compact('orders'));
    }

    public function store(OrderRequest $request)
    {
        $order = $this->orderService->add($request);
        return new OrderResource($order);
    }

    public function show(Order $order)
    {
//        dd(app(OrderApiHandler::class)->getRequestHeader());
//        $orderimg = app(OrderimgHandler::class);
//        return $orderimg->generate();
//        $disk = Storage::disk('public');
//        $directory = '/test';
//        $files = $disk->files($directory);
//        foreach($files as $file) {
//            dispatch(new FileWords($file))->delay(now()->addSeconds(2));
//        }
        // 校验权限
        $this->authorize('own', $order);
        return view('domained::orders.show', compact('order'));
    }

    public function viewReport(Order $order, OrderApiHandler $apiHandler)
    {
        //校验权限
        $this->authorize('own', $order);
        $pdf = $apiHandler->extractReportPdf($order->api_orderid);
        return view('domained::orders.view_report', compact('order', 'pdf'));
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
        //校验权限
        return response()->download(storage_path() . '/app/' . $order->report_path, $order->writer . '-' . $order->title . '.zip');
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
        return view('domained::orders.qrcode.index', compact('img_url'));
    }
}
