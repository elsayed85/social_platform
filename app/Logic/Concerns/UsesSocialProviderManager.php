<?php

namespace App\Logic\Concerns;

use App\Logic\Contracts\SocialProvider;
use App\Logic\Facades\SocialProviderManager;
use App\Logic\Models\Account;

trait UsesSocialProviderManager
{
    public function connectProvider(Account $account): SocialProvider
    {
        return SocialProviderManager::connect($account->provider, $account->values())
            ->useAccessToken($account->access_token->toArray());
    }
}
