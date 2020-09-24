<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class InvitOfficialController extends Controller
{
    protected $app;

    public function __construct()
    {
        $this->app = app('official_account');
    }

    /**
     * 获取二维码图片
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // 有效期 1 天的二维码
        if($request->has('uid')) {
            $uid = $request->uid;
        }
        $params = 'JC=' . $uid;
        $qrCode = $this->app->qrcode;
        $result = $qrCode->temporary($params, 3600 * 24);
        $url = $qrCode->url($result['ticket']);
        return response(compact('url'), 200);
    }
}
