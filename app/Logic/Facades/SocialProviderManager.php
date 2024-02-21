<?php

namespace App\Logic\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Logic\Contracts\SocialProvider connect(string $provider, array $values = [])
 * @method static \App\Logic\Contracts\SocialProvider useAccessToken(array $token = [])
 *
 * @see \App\Logic\Abstracts\SocialProviderManager
 */
class SocialProviderManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SocialProviderManager';
    }
}
