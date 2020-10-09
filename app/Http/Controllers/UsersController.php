<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function resetPassword(Request $request)
    {
        $user = $request->user();
        $password = $request->password;
        $this->setUserPassword($user, $password);
        $this->guard()->login($user);
        if($request->wantsJson()) {
            return new JsonResponse(['message' => '修改成功'], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', '修改成功');
    }

    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function sendResetResponse(Request $request, $response)
    {
        if($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }
}
