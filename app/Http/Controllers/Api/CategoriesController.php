<?php

namespace App\Http\Controllers\Api;

use App\Events\CheckVipExpirAt;
use App\Events\RefreshPaged;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        //以下为测试
        //在搜索引擎搜索个关键词，进入网站
        $word = search_word_from(URL::previous());
        if(!empty($word['from'])) {
            \Cache::put('word', $word, now()->addDay());
        }
        $categories = Category::query()->where('status', 1)->get();
//        $user = \Auth::user();
//        event(new RefreshPaged($user));
        return CategoryResource::collection($categories)->collection->groupBy('classid');
    }
}
