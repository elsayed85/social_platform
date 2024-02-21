<?php

namespace App\Logic\SocialProviders\Meta;

use Illuminate\Support\Str;
use App\Logic\Http\Resources\AccountResource;
use App\Logic\SocialProviders\Meta\Concerns\ManagesFacebookOAuth;
use App\Logic\SocialProviders\Meta\Concerns\ManagesFacebookPageResources;

class FacebookPageProvider extends MetaProvider
{
    use ManagesFacebookOAuth;
    use ManagesFacebookPageResources;

    public bool $onlyUserAccount = false;

    public static function externalPostUrl(AccountResource $accountResource): string
    {
        return "https://www.facebook.com/{$accountResource->pivot->provider_post_id}";
    }
}
