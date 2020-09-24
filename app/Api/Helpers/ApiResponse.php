<?php

namespace App\Api\Helpers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

use Response;

trait ApiResponse
{
    protected $statusCode = FoundationResponse::HTTP_OK;

    //获取状态码
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode, $httpCode = null)
    {
        $httpCode = $httpCode ?? $statusCode;
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respond($data, $header = [])
    {
        return Response::json($data, $this->getStatusCode(), $header);
    }

    public function status($status, array $data, $code = null)
    {
        if($code) $this->setStatusCode();
        $status = [
            'status' => $status,
            'code' => $this->statusCode
        ];
        $data = array_merge($status, $data);
        return $this->respond($data);
    }

    /*
   * 格式
   * data:
   *  code:422
   *  message:xxx
   *  status:'error'
   */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error')
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

    public function message($message, $status = 'success')
    {
        return $this->status($status, [
            'message' => $message
        ]);
    }

    public function internalError($message = 'Internal Error!')
    {
        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function created($message = 'created')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED);
    }

    public function success($data, $status = 'success')
    {
        $base = ['message' => $message ?? '操作成功', "code" => $this->getStatusCode(), 'status' => "success"];
        if($data instanceof JsonResource || $data instanceof ResourceCollection) {
        } elseif($data instanceof Collection || $data instanceof AbstractPaginator) {
            // dd($data);
            $data = JsonResource::collection($data);
        } elseif(is_object($data) || is_array($data)) {
            $data = new JsonResource($data);
        } else {
            return array_merge($base, ['data' => $data]);
        }
        return $data->additional(array_merge($base, $data->additional));
        // return $this->status($status, compact('data'));
    }

    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message, FoundationResponse::HTTP_NOT_FOUND);
    }
}
