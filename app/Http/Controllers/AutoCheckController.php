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
        return view('ai_rewrite.index');
    }

    public function store(AutoCheckRequest $request)
    {
        $user = $request->user();
        if($user->jc_times <= 0) {
            throw new InvalidRequestException('您的降重次数不足!');
        }

        $result = app(AiWriterHandler::class)->getContent(
            $request->input('txt', ''),
            $request->input('th', ''),
            $request->input('filter', ''),
            $request->input('corewordfilter', ''),
            $request->input('sim', ''),
            $request->input('retype', '')
        );

        $user->decreaseJcTimes();
        return $result;
    }

    public function show(AutoCheck $autoCheck)
    {
        return new AutoCheckResource($autoCheck);
    }

    public function rewrite()
    {
        return view('rewrite.index');
    }
}
