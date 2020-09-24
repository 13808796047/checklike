<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use Dcat\Admin\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Content $content, Request $request)
    {
        $classOrders = Category::query()->with(['orders' => function($query) use ($request) {
            $query->withOrder($request->date);
        }])->get();
//        $totalOrders = Category::query()->with(['orders' => function($query) use ($request) {
//            $query->withOrder('created_at', $request->date);
//        }])->get();
        $sourceOrders = Order::query()->withOrder($request->date)->get()->groupBy('from');
//        $sourceTotalOrders = Order::query()->withOrder('created_at', $request->date)->get()->groupBy('from');
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
