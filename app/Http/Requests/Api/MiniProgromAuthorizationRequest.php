<?php

namespace App\Http\Requests\Api;


class MiniProgromAuthorizationRequest extends FormRequest
{

    public function rules()
    {
        return [
            'code' => 'required|string',
        ];
    }
}
