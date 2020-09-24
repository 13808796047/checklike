<?php


namespace App\Handlers;


use Intervention\Image\Facades\Image;

class OrderimgHandler
{
    public function generate($title, $writer, $category_name, $classid, $created_at, $rate)
    {
        switch ($classid) {
            case 2:
                $img_path = public_path('orderimg/wp.jpg');
                break;
            case 4:
                $img_path = public_path('orderimg/wf.jpg');
                break;
            default:
                $img_path = public_path('orderimg/xx.jpg');
        }
        $img = Image::make($img_path);
        $i = 500;
        $fontTtf = public_path('orderimg/msyhl.ttc');
        $fontSize = 26;

        $box = autowrap($fontSize, 0, $fontTtf, $title, $i);
        $img->text('论文题目:', 180, 350, function($font) use ($fontSize, $fontTtf) {
            $font->file($fontTtf);
            $font->size($fontSize);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });
        $img->text($box, 250, 350, function($font) use ($fontSize, $fontTtf) {
            $font->file($fontTtf);
            $font->size($fontSize);
            $font->color('#000');
            $font->valign('top');
        });
        $img->text('论文作者:', 180, 450, function($font) use ($fontSize, $fontTtf) {
            $font->file($fontTtf);
            $font->size($fontSize);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });
        $img->text($writer, 250, 450, function($font) use ($fontSize, $fontTtf) {
            $font->file($fontTtf);
            $font->size($fontSize);
            $font->color('#000');
//            $font->align('center');
            $font->valign('top');
        });
        $img->text('检测系统:', 180, 520, function($font) use ($fontSize, $fontTtf) {
            $font->file($fontTtf);
            $font->size($fontSize);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });
        $img->text($category_name, 250, 520, function($font) use ($fontSize, $fontTtf) {
            $font->file($fontTtf);
            $font->size($fontSize);
            $font->color('#000');
//            $font->align('center');
            $font->valign('top');
        });
        $img->text('检测时间:', 180, 590, function($font) use ($fontSize, $fontTtf) {
            $font->file($fontTtf);
            $font->size($fontSize);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });
        $img->text($created_at, 250, 590, function($font) use ($fontSize, $fontTtf) {
            $font->file($fontTtf);
            $font->size($fontSize);
            $font->color('#000');
//            $font->align('center');
            $font->valign('top');
        });
        $img->text(str_replace('%', '', $rate), 509, 780, function($font) use ($fontSize, $fontTtf) {
            $font->file(public_path('orderimg/FZSHHJW.TTF'));
            $font->size(44);
            $font->color('#f00');
            $font->align('center');
            $font->valign('top');
            $font->angle(15);
        });
        return $img->encode('data-url');
    }
}
