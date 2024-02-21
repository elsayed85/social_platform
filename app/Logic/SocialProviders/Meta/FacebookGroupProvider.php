<?php

namespace App\Logic\SocialProviders\Meta;

use App\Logic\Http\Resources\AccountResource;
use App\Logic\SocialProviders\Meta\Concerns\ManagesFacebookGroupResources;
use App\Logic\SocialProviders\Meta\Concerns\ManagesFacebookOAuth;

class FacebookGroupProvider extends MetaProvider
{
    use ManagesFacebookOAuth;
    use ManagesFacebookGroupResources;

    public bool $onlyUserAccount = false;

    public static function externalPostUrl(AccountResource $accountResource): string
    {
        return "https://www.facebook.com/{$accountResource->pivot->provider_post_id}";
    }
}
