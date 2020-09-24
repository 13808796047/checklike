<?php

namespace App\Http\Requests\Api;


class AuthorizationRequest extends FormRequest
{

    public function rules()
    {
        return [
            'phone' => 'required|string',
//            'password' => 'required|alpha_dash|min:6',
            'type' => 'required'
        ];
    }
}
