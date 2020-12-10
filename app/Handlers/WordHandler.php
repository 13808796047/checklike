<?php


namespace App\Handlers;


use mysql_xdevapi\Exception;
use PhpOffice\PhpWord\IOFactory;

class WordHandler
{
    public function save($content, $folder, $file_prefix)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        dd($content);
        $template = $phpWord->loadTemplate(public_path('template/template.docx'));
        $template->setValue('content', $content);
//        $section = $phpWord->addSection();
//        $contentFormat = str_replace("\r\n", "<w:br />", $content);
////        $contentFormat = htmlspecialchars($content);
//        $section->addText($contentFormat);
        // 保存文件
        //生成的文檔爲Word2007
//        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $folder_name = "uploads/$folder/" . date('Ym/d', time());
        $upload_path = public_path() . '/' . $folder_name;
        $filename = $file_prefix . '_' . time() . '_' . \Str::random(10) . '.docx';
        try {
            if(!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
                chmod($upload_path, 0777);
            }
            chmod($upload_path, 0777);
            $template->save($upload_path . '/' . $filename);
            return [
                'path' => config('app.url') . "/$folder_name/$filename"
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
