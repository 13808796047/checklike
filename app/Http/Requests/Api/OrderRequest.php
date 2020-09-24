<?php

namespace App\Http\Requests\Api;


class OrderRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'writer' => 'required',
            'type' => 'required',
            'content' => 'required_without:file_id',
            'file_id' => 'required_without:content'
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => '标题',
            'writer' => '作者',
            'type' => '类型',
            'file_id' => '论文文件',
            'content' => '粘贴内容'
        ];
    }
}
