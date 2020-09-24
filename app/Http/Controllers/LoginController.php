<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('domained::pages.index');
    }

    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'phone' => 'required|unique:users|max:50',
            'password' => 'required|confirmed|min:6'
        ]);
        $credentials['phone'] = $request->phone;
        $credentials['password'] = $request->password;
        if(\Auth::attempt($credentials)) {
            session()->flash('success', '欢迎回来！');
            return redirect()->route('domained::pages.index');
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }
}
