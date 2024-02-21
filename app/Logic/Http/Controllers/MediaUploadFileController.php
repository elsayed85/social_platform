<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Logic\Http\Requests\MediaUploadFile;
use App\Logic\Http\Resources\MediaResource;

class MediaUploadFileController extends Controller
{
    public function __invoke(MediaUploadFile $upload): MediaResource
    {
        return new MediaResource($upload->handle());
    }
}
