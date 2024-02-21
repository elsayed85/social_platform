<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use App\Logic\Http\Resources\MediaResource;
use App\Logic\Models\Media;

class MediaFetchUploadsController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        $records = Media::latest('created_at')->simplePaginate(30);

        return MediaResource::collection($records);
    }
}
