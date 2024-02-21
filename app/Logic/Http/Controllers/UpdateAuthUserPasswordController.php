<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use App\Logic\Http\Requests\UpdateAuthUserPassword;

class UpdateAuthUserPasswordController extends Controller
{
    public function __invoke(UpdateAuthUserPassword $updateAuthUserPassword): RedirectResponse
    {
        $updateAuthUserPassword->handle();

        return back();
    }
}
