<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalException;
use App\Exceptions\InvalidRequestException;
use App\Handlers\AiWriterHandler;
use App\Handlers\AutoCheckHandler;
use App\Http\Requests\AutoCheckRequest;
use App\Http\Resources\AutoCheckResource;
use App\Models\AutoCheck;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AutoCheckController extends Controller
{
    public function index()
    {
        return view('domained::ai_rewrite.index');
    }

    public function store(AutoCheckRequest $request)
    {
        $user = $request->user();
        if($user->jc_times <= 0) {
            throw new InvalidRequestException('您的降重次数不足!');
        }

        $result = app(AiWriterHandler::class)->getContent($request->input('content', ''));

        if($result['status'] == 0) {
            return response(compact('result'), 500);
        }
        $user->decreaseJcTimes();
        return response(compact('result', 'user'), 200);

//        $data = AutoCheck::create([
//            'content_before' => $request->input('content'),
//            'user_id' => $user->id,
//        ]);
//        $user->decreaseJcTimes();
//        return new AutoCheckResource($data);
    }

    public function show(AutoCheck $autoCheck)
    {
        return new AutoCheckResource($autoCheck);
    }
}
