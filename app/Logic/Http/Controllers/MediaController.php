<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use \Illuminate\Http\Response as HttpResponse;
use App\Logic\Facades\Services;
use App\Logic\Http\Requests\DeleteMedia;

class MediaController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Media', [
            'is_configured_service' => Services::isConfigured()
        ]);
    }

    public function destroy(DeleteMedia $deleteMediaFiles): HttpResponse
    {
        $deleteMediaFiles->handle();

        return response()->noContent();
    }
}
