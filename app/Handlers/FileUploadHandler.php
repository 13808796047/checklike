<?php

namespace App\Handlers;

use mysql_xdevapi\Exception;

class FileUploadHandler
{
    protected $allowed_ext = ['txt', 'docx'];

    public function save($file, $folder, $file_prefix)
    {
        $folder_name = "uploads/$folder/" . date('Ym/d', time());
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path() . '/' . $folder_name;
        //获取文件的后缀名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'docx';
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . \Str::random(10) . '.' . $extension;

        if(!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        //将文件移动到目标存储路径中
        $file->move($upload_path, $filename);
        return [
            'path' => config('app.url') . "/$folder_name/$filename",
            'real_path' => "$upload_path/$filename"
        ];
    }

    public function saveTxt($txt_content, $folder, $file_prefix)
    {
        $folder_name = "uploads/$folder/" . date('Ym/d', time());
        $upload_path = public_path() . '/' . $folder_name;
        $filename = $file_prefix . '_' . time() . '_' . \Str::random(10) . '.txt';
        try {
            if(!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
                chmod($upload_path, 0777);
            }
            file_put_contents($upload_path . '/' . $filename, $txt_content);
            return [
                'path' => config('app.url') . "/$folder_name/$filename"
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
