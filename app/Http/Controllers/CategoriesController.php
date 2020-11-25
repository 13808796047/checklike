<?php

namespace App\Http\Controllers;

use App\Events\CheckVipExpirAt;
use App\Events\RefreshPaged;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($classid, Request $request, CategoryService $categoryService)
    {
        $user = $request->user();
        event(new RefreshPaged($user, $classid));
        $categories = Category::where(['classid' => $classid, 'status' => 1])->with(['users' => function($query) use ($user) {
            return $query->where('users.id', $user->id);
        }])->get();

        return view('orders.create', compact('categories'));
    }

}
