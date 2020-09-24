<?php

namespace App\Http\Requests;


use App\Http\Requests\Api\FormRequest;

class AutoCheckRequest extends FormRequest
{
    public function rules()
    {
        return [
            'content' => 'required|min:1|max:1200'
        ];
    }

    public function attributes()
    {
        return [
            'content' => '内容'
        ];
    }
}
