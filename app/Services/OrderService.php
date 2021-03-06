<?php


namespace App\Services;


use App\Exceptions\InternalException;
use App\Exceptions\InvalidRequestException;
use App\Handlers\FileUploadHandler;
use App\Handlers\FileWordsHandle;
use App\Handlers\OrderApiHandler;
use App\Handlers\WordHandler;
use App\Jobs\CloseOrder;
use App\Jobs\CloudCouvertFile;
use App\Jobs\IOSPaidMessage;
use App\Jobs\OrderPendingMsg;
use App\Jobs\UpdateIsFree;
use App\Models\Category;
use App\Models\CouponCode;
use App\Models\File;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderService
{
    public function add($request)
    {
        $order = \DB::transaction(function() use ($request) {
            $category = Category::find($request->cid);
            $file = File::find($request->file_id);
            $user = $request->user();

            $result = $this->converFile($category, $request->type, $request->content, $file, $user->id);
            $words = $result['words'];


//            if($request->type == 'file') {

//                $file = File::find($request->file_id);
//                if($file->type == 'txt') {
//                    $content = remove_spec_char(convert2utf8(file_get_contents($file->real_path)));
//                    $words = count_words(remove_spec_char(convert2utf8($content)));
//                    if($category->classid == 3) {
//                        $result = $wordHandler->save($content, 'files', $user->id);
//                    }
//                } else {
//                    $res = app(FileWordsHandle::class)->submitCheck($file->path);
//                    $words = app(FileWordsHandle::class)->queryParsing($res['data']['orderid'])['data']['wordCount'];
//                    $result = $file;
//                    if($category->classid == 4 && $file->type == 'docx') {
//                        $content = read_docx($file->real_path);
//                        $result = app(FileUploadHandler::class)->saveTxt($content, 'files', $user->id);
//                    }
//                }
//            } else {
//                $content = remove_spec_char($request->input('content', ''));
//                $words = count_words($content);
//                if($category->classid == 3) {
//                    $result = $wordHandler->save($content, 'files', $user->id);
//                } else {
//                    $result = app(FileUploadHandler::class)->saveTxt($content, 'files', $user->id);
//                }
//            }
            if($words <= 0) {
                throw new InvalidRequestException('还未解析完成', 400);
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
            $referer = \Cache::get('word');
            $order = new Order([
                'cid' => $request->cid,
                'title' => $request->title,
                'writer' => Str::limit($request->writer, $limit = 3, $end = '...'),
                'endDate' => $request->endDate ?? "",
                'publishdate' => $request->publishdate ?? "",
                'date_publish' => $request->date_publish,
                'words' => ceil($words),
                'paper_path' => $result['path'] ?? '',
                'from' => $request->from,
                'content' => '',
                'phone' => $request->phone ?? '',
                'referer' => $referer['from'],
                'keyword' => $referer['keyword']
            ]);
            $order->user()->associate($user);
            switch ($user->user_group) {
                case 1:
                    $price = $category->agent_price1;
                    break;
                case 2:
                    $price = $category->agent_price2;
                    break;
                case 3:
                    $price = $category->vip_price;
                    break;
                default:
                    $price = $category->price;
            }
            if($user->is_free && $category->cid == 4) {
                $words = max($words - 10000, 0);
            }
            switch ($category->price_type) {
                case Category::PRICE_TYPE_THOUSAND:
                    $amount = round($price * ceil($words / 1000), 2);
                    break;
                case Category::PRICE_TYPE_MILLION:
                    $amount = round($price * ceil($words / 10000), 2);
                    break;
                default:
                    $amount = $price;
            }


            $order->price = $amount;

            $order->save();

            if(isset($file)) {
                $file->update([
                    'order_id' => $order->id,
                ]);
            }
            \Cache::forget('word');


            $this->OrderCreated($order);
            return $order;
        });
        return $order;
    }

    public function OrderCreated(Order $order)
    {
        if(!$order->phone) {
            dispatch(new OrderPendingMsg($order))->delay(now()->addMinutes(2));
        } else {
            dispatch(new IOSPaidMessage($order));
        }

    }

    public function converFile(Category $category, $type, $content, $file, $file_prefix)
    {
        $wordHandler = app(WordHandler::class);
        $fileWords = app(FileWordsHandle::class);
        $upload = app(FileUploadHandler::class);

        if($type == 'file') {
            if($file->type == 'txt') {
                $content = remove_spec_char(convert2utf8(file_get_contents($file->real_path)));
                $words = count_words(remove_spec_char(convert2utf8($content)));
                if($category->classid == 3) {
                    $result = $wordHandler->save($content, 'files', $file_prefix);
                }
            } else {
                $words = $fileWords->queryParsing($fileWords->submitCheck($file->path)['data']['orderid'])['data']['wordCount'];
                $result = $file;
                if($category->classid == 4 && $file->type == 'docx') {
                    $content = read_docx($file->real_path);
                    $result = $upload->saveTxt($content, 'files', $file_prefix);
                }
            }
        } else {
//            $words = count_words(remove_spec_char($content));
            $words = $fileWords->queryParsing($fileWords->submitCheck($result['path'])['data']['orderid'])['data']['wordCount'];
            $result = $upload->saveTxt($content, 'files', $file_prefix);

        }
        $result = ['path' => $result['path'], 'words' => $words, 'content' => $content];
        return $result;
    }


    public function calcPrice(User $user, Category $category, $words, $price)
    {
        switch ($category->price_type) {
            case Category::PRICE_TYPE_THOUSAND:
                $price = round($price * ceil($words / 1000), 2);
                break;
            case Category::PRICE_TYPE_MILLION:
                $price = round($price * ceil($words / 10000), 2);
                break;
            default:
                $price = $price;
        }
        if($user->is_free) {
            $price = max($words - 10000, 0) * $price;
        }
        return $price;
    }

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
