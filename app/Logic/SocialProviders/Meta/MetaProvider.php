<?php

namespace App\Logic\SocialProviders\Meta;

use App\Logic\Abstracts\SocialProvider;
use App\Logic\Http\Resources\AccountResource;
use App\Logic\SocialProviders\Meta\Concerns\ManagesMetaResources;
use App\Logic\SocialProviders\Meta\Concerns\ManagesRateLimit;
use App\Logic\SocialProviders\Meta\Concerns\MetaOauth;

class MetaProvider extends SocialProvider
{
    use ManagesRateLimit;
    use MetaOauth;
    use ManagesMetaResources;

    public array $callbackResponseKeys = ['code'];

    protected string $apiVersion = 'v16.0';
    protected string $apiUrl = 'https://graph.facebook.com';

    protected string $scope = 'public_profile,business_management,pages_show_list,pages_read_engagement,read_insights,pages_manage_posts,publish_to_groups,groups_access_member_info';

    public function getAuthUrl(): string
    {
        return '';
    }

    public static function externalPostUrl(AccountResource $accountResource): string
    {
        return '#';
    }
}
