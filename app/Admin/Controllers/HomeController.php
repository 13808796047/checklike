<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Content $content, Request $request)
    {
        $classOrders = Category::query()
            ->withCount(['orders as order1' => function($query) use ($request) {
                $query->withOrder('created_at', $request->date);
            }])
            ->withCount(['orders as order2' => function($query) use ($request) {
                $query->withOrder('date_pay', $request->date);
            }])->withCount(['orders as total_price' => function($query) use ($request) {
                $query->withOrder('date_pay', $request->date)->select(\DB::raw("sum(pay_price)"));
            }])
            ->get(['name']);
        switch ($request->date) {
            case "yesterday":
                $start = Carbon::now()->subDay()->startOfDay()->toDateTimeString();
                $end = Carbon::now()->subDay()->endOfDay()->toDateTimeString();
                break;
            case 'month':
                $start = Carbon::now()->startOfMonth()->toDateTimeString();
                $end = Carbon::now()->endOfMonth()->toDateTimeString();
                break;
            case 'pre_month':
                $start = Carbon::now()->subMonth()->startOfDay()->toDateTimeString();
                $end = Carbon::now()->subMonth()->endOfDay()->toDateTimeString();
                break;
            default:
                $start = Carbon::now()->startOfDay()->toDateTimeString();
                $end = Carbon::now()->endOfDay()->toDateTimeString();
        }

        $sourceOrders = Order::query()->select(\DB::raw("count(created_at between '$start' and '$end' or null) as name1 , count(date_pay between '$start' and '$end'  or null) as name2,sum(if(date_pay between '$start' and '$end' ,pay_price,0)) as total_price"), 'from')->groupBy('from')->get();

        return $content
            ->title('首页')
            ->body(view('admin.home.index', [
                'class_orders' => $classOrders,
//                'total_orders' => $totalOrders,
                'source_orders' => $sourceOrders,
//                'source_total_orders' => $sourceTotalOrders,
            ]));
//            ->header('Dashboard')
//            ->description('Description...')
//            ->body(function(Row $row) {
//                $row->column(12, function(Column $column) {
////                    $column->row(Dashboard::title());
//                    $column->row(new Examples\Tickets());
//                });

//                $row->column(6, function(Column $column) {
//                    $column->row(function(Row $row) {
//                        $row->column(6, new Examples\NewUsers());
//                        $row->column(6, new Examples\NewDevices());
//                    });
//
//                    $column->row(new Examples\Sessions());
//                    $column->row(new Examples\ProductOrders());
//                });
//    });
    }

}
