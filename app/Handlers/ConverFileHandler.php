<?php


namespace App\Handlers;


use App\Models\File;

class ConverFileHandler
{
    public function conver()
    {
        $wordHandler = app(WordHandler::class);

        if($request->type == 'file') {
            $file = File::find($request->file_id);
            if($file->type == 'txt') {
                $content = remove_spec_char(convert2utf8(file_get_contents($file->real_path)));
                $words = count_words(remove_spec_char(convert2utf8($content)));
                if($category->classid == 3) {
                    $result = $wordHandler->save($content, 'files', $user->id);
                }
            } else {
                $res = app(FileWordsHandle::class)->submitCheck($file->path);
                $words = app(FileWordsHandle::class)->queryParsing($res['data']['orderid'])['data']['wordCount'];
                $result = $file;
                if($category->classid == 4 && $file->type == 'docx') {
                    $content = read_docx($file->real_path);
                    $result = app(FileUploadHandler::class)->saveTxt($content, 'files', $user->id);
                }
            }
        } else {
            $content = remove_spec_char($request->input('content', ''));
            $words = count_words($content);
            if($category->classid == 3) {
                $result = $wordHandler->save($content, 'files', $user->id);
            } else {
                $result = app(FileUploadHandler::class)->saveTxt($content, 'files', $user->id);
            }
        }
    }
}
