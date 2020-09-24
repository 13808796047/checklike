<?php

namespace App\Http\Controllers;

use App\Handlers\FileUploadHandler;
use App\Http\Requests\Api\FileRequest;
use App\Http\Resources\FileResource;
use App\Services\FileService;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function store(FileRequest $request, FileUploadHandler $uploadHandler)
    {
        $file = $this->fileService->add($request, $uploadHandler);
        return new FileResource($file);
    }
}
