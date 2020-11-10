<?php


namespace App\Admin\Controllers;


use Dcat\Admin\Traits\HasUploadedFile;
use Illuminate\Http\Request;

class FileController
{
    use HasUploadedFile;

    public function handle(Request $request)
    {
        $disk = $this->disk($request->disk);
        // 判断是否是删除文件需求
        if($this->isDeleteRequest()) {
            // 删除文件并响应
            return $this->deleteFileAndResponse($disk);
        }
        // 获取上传的文件
        $file = $this->file();
        $dir = $request->disk;
        $newName = 'report-' . $request->api_orderid . '.' . $file->getClientOriginalExtension();
        $result = $disk->putFileAs($dir, $file, $newName);

        $path = "{$dir}/$newName";

        return $result
            ? $this->responseUploaded($path, $disk->url($path))
            : $this->responseErrorMessage('文件上传失败');
    }
}
