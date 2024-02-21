<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use App\Logic\Http\Resources\AccountResource;
use App\Logic\Models\Account;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'accounts' => fn() => AccountResource::collection(Account::oldest()->get())->resolve()
        ]);
    }
}
