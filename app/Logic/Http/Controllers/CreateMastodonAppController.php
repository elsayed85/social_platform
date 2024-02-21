<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Logic\Http\Requests\CreateMastodonApp;

class CreateMastodonAppController extends Controller
{
    public function __invoke(CreateMastodonApp $createMastodonApp): Response
    {
        $createMastodonApp->handle();

        return response()->noContent();
    }
}
