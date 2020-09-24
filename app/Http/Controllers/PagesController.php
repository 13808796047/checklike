<?php

namespace App\Http\Controllers;

use App\Handlers\BaiduPayHandler;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class PagesController extends Controller
{
    public function index()
    {
        //以下为测试
        //在搜索引擎搜索个关键词，进入网站
        $word = search_word_from(URL::previous());
        if(!empty($word['from'])) {
            \Cache::put('word', $word, now()->addDay());
        }
        return view('pages.index');
    }
}
