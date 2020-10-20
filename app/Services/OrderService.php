<?php


namespace App\Services;


use App\Exceptions\InvalidRequestException;
use App\Handlers\FileUploadHandler;
use App\Handlers\FileWordsHandle;
use App\Handlers\OrderApiHandler;
use App\Handlers\WordHandler;
use App\Jobs\CloudCouvertFile;
use App\Jobs\OrderPendingMsg;
use App\Models\Category;
use App\Models\File;
use App\Models\Order;

class OrderService
{
    public function add($request)
    {
        $order = \DB::transaction(function() use ($request) {
            $category = Category::findOrFail($request->cid);
            $user = \Auth()->user();
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
            if($words > 2500 && $user->redix == 1 && $request->from != 'wp-wx') {
                $resultWords = \Cache::remember('user' . $user->id, now()->addDay(), function() use ($words) {
                    return $this->calcWords($words);
                });
                $words += $resultWords;
            }

            if($words <= $category->min_words && $words >= $category->max_words) {
                throw new InvalidRequestException("检测字数必须在" . $category->min_words . "与" . $category->max_words . "之间", 500);
            }
            switch ($category->price_type) {
                case Category::PRICE_TYPE_THOUSAND:
                    $price = round($category->price * ceil($words / 1000), 2);
                    break;
                case Category::PRICE_TYPE_MILLION:
                    $price = round($category->price * ceil($words / 10000), 2);
                    break;
                default:
                    $price = $category->price;
            }
            $referer = \Cache::get('word');
            //创建订单
            $order = new Order([
                'cid' => $request->cid,
                'title' => $request->title,
                'writer' => $request->writer,
                'endDate' => $request->endDate ?? "",
                'publishdate' => $request->publishdate ?? "",
                'date_publish' => $request->date_publish,
                'words' => ceil($words),
                'paper_path' => $result['path'] ?? '',
                'from' => $request->from,
                'content' => '',
                'referer' => $referer['from'],
                'keyword' => $referer['keyword']
            ]);
            $order->user()->associate($user);
            if($user->is_free && $category->id == 1) {
                if($user->dev_weixin_openid || $user->dev_weapp_openid) {
                    $price = max($price - 3, 0);
                }
            }
            $order->price = $price;
            $order->save();
            $file->update([
                'order_id' => $order->id,
            ]);
            dd($file);
            \Cache::forget('word');
            $order->orderContent()->create([
                'content' => $content ?? ''
            ]);
            $this->checkWords($order);
            if($order->status == 0) {
                dispatch(new OrderPendingMsg($order))->delay(now()->addMinutes(2));
            }
            return $order;
        });
        return $order;
    }


    protected function checkWords(Order $order)
    {
        if($order->category->classid == 4) {
            if($order->file->type == 'docx') {
                $content = read_docx($order->file->real_path);
                $words = count_words($content);
                if($words / $order->words > 1.15) {
                    $this->cloudConert($order);
                }
            } else {
                $this->cloudConert($order);
            }
        }
    }

    protected function cloudConert(Order $order)
    {
        $this->dispatch(new CloudCouvertFile($order));
    }

    //计算字数
    public function calcWords($words)
    {
        $diff = 1000 - substr($words, -3);
        switch ($diff) {
            case $diff < 500:
                $newWords = rand($words + $diff, $words + 1000 - $diff);
                break;
            case $diff > 500:
                $newWords = rand($words + $diff, $words + 1000);
                break;
            default:
                $newWords = $words + rand($diff, 1000);
        }
        return $newWords - $words;
    }

    public function getPdf($api_orderid)
    {
        $apiHandler = app(OrderApiHandler::class);
        return $apiHandler->extractReportPdf($api_orderid);
    }
}
