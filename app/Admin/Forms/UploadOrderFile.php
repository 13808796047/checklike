<?php

namespace App\Admin\Forms;

use Dcat\Admin\Traits\HasUploadedFile;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

class UploadOrderFile extends Form
{

    public function handle(array $input)
    {
        $disk = $this->disk('local');

        // 获取上传的文件
        $file = $this->file();

        $dir = 'downloads';

        $id = $input['id'] ?? null;
        if(!$id) {
            return $this->error('参数错误');
        }
        $status = $input['status'];
        $order = \App\Models\Order::query()->find($id);
        if(!$order) {
            return $this->error('订单不存在!');
        }
        $newName = 'report-' . $order->api_orderid . $file->getClientOriginalExtension();
        $result = $disk->putFileAs($dir, $file, $newName);
        $path = "{$dir}/$newName";
        $order->update([
            'report_path' => $disk->url($path)
        ]);
        return $this->success('上传成功!');
    }

    public function form()
    {
        $this->file('file', 'zip文件');
    }

}
