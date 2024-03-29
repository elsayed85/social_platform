<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use App\Logic\Facades\Services;
use App\Logic\Http\Requests\SaveService;

class ServicesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Services', [
            'services' => Services::all()
        ]);
    }

    public function update(SaveService $saveService): RedirectResponse
    {
        $saveService->handle();

        return back();
    }
}
