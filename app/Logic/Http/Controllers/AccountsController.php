<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;
use App\Logic\Actions\UpdateOrCreateAccount;
use App\Logic\Concerns\UsesSocialProviderManager;
use App\Logic\Facades\Services;
use App\Logic\Http\Resources\AccountResource;
use App\Logic\Models\Account;

class AccountsController extends Controller
{
    use UsesSocialProviderManager;

    public function index(): Response
    {
        return Inertia::render('Accounts/Accounts', [
            'accounts' => AccountResource::collection(Account::latest()->get())->resolve(),
            'is_configured_service' => Arr::except(Services::isConfigured(), ['unsplash', 'tenor']),
        ]);
    }

    public function update(Account $account): RedirectResponse
    {
        $connection = $this->connectProvider($account);

        $response = $connection->getAccount();

        if ($response->hasError()) {
            if ($response->isUnauthorized()) {
                return redirect()->back()->with('error', 'The account cannot be updated. Re-authenticate your account.');
            }

            return redirect()->back()->with('error', 'The account cannot be updated.');
        }

        (new UpdateOrCreateAccount())($account->provider, $response->context(), $account->access_token->toArray());

        return redirect()->back();
    }

    public function delete(Account $account): RedirectResponse
    {
        $connection = $this->connectProvider($account);

        if (method_exists($connection, 'revokeToken')) {
            $connection->revokeToken();
        }

        $account->delete();

        return redirect()->back();
    }
}