<?php


namespace App\Services;


use App\Models\File;

class FileService
{
    public function add($request, $uploadHandler)
    {

        $user = \Auth::user();
        if($file = $request->file) {
            //文件后缀
            $fileTypes = ['docx', 'txt', 'doc'];
            //获取文件类型后缀
            $extension = $file->getClientOriginalExtension();
            //是否是要求的文件
            $isInFileType = in_array($extension, $fileTypes);
            if(!$isInFileType) {
                throw new \Exception('文件格式不合法!', 400);
            }
            $result = $uploadHandler->save($file, 'files', $user->id);
            $data = File::create([
                'type' => $extension,
                'user_id' => $user->id,
                'path' => $result['path'],
                'real_path' => $result['real_path'],
            ]);
        }

        return $data;
    }
}
