<?php

namespace App\Handlers;


use Illuminate\Support\Facades\Storage;

class FileUploadHandler
{
    protected $allowed_ext = ['txt', 'docx', 'doc'];

    public function save($file, $folder, $file_prefix)
    {
        $folder_name = "uploads/$folder/" . date('Ym/d', time());
        $upload_path = public_path() . '/' . $folder_name;
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $file_prefix . '_' . time() . '_' . \Str::random(10) . '.' . $extension;

        if(!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        $file->move($upload_path, $filename);
        return [
            'path' => config('app.url') . "/$folder_name/$filename",
            'real_path' => "$upload_path/$filename"
        ];
    }

    public function saveTxt($txt_content, $folder, $file_prefix, $extension = 'txt')
    {
        $folder_name = "uploads/$folder/" . date('Ym/d', time());
        $upload_path = public_path() . '/' . $folder_name;
        $filename = $file_prefix . '_' . time() . '_' . \Str::random(10) . '.' . $extension;
        try {
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
                chmod($upload_path, 0777);
            }
            file_put_contents($upload_path . '/' . $filename, $txt_content);
            chmod($upload_path . '/' . $filename, 0777);
            return [
                'path' => config('app.url') . "/$folder_name/$filename"
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
