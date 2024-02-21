<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Logic\Http\Requests\MediaDownloadExternal;
use App\Logic\Http\Resources\MediaResource;

class MediaDownloadExternalController extends Controller
{
    public function __invoke(MediaDownloadExternal $downloadMedia): array
    {
        $media = $downloadMedia->handle();

        return MediaResource::collection($media)->resolve();
    }
}
