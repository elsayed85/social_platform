<?php

namespace App\Logic\SocialProviders\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;
use App\Logic\Abstracts\SocialProvider;
use App\Logic\Facades\Services;
use App\Logic\Http\Resources\AccountResource;
use App\Logic\SocialProviders\Twitter\Concerns\ManagesOAuth;
use App\Logic\SocialProviders\Twitter\Concerns\ManagesRateLimit;
use App\Logic\SocialProviders\Twitter\Concerns\ManagesResources;

class TwitterProvider extends SocialProvider
{
    use ManagesRateLimit;
    use ManagesOAuth;
    use ManagesResources;

    public array $callbackResponseKeys = ['oauth_token', 'oauth_verifier'];

    protected string $apiVersion = '2';

    public TwitterOAuth $connection;

    // Overwrite __construct to use Twitter SDK
    public function __construct(Request $request, string $clientId, string $clientSecret, string $redirectUrl, array $values = [])
    {
        $this->connection = new TwitterOAuth($clientId, $clientSecret);
        $this->connection->setApiVersion($this->apiVersion);
        $this->connection->setTimeouts(10, 60);

        parent::__construct($request, $clientId, $clientSecret, $redirectUrl, $values);
    }

    public function getTier(): string
    {
        return Services::get('twitter', 'tier') ?? 'legacy';
    }

    public static function externalPostUrl(AccountResource $accountResource): string
    {
        return "https://twitter.com/$accountResource->username/status/{$accountResource->pivot->provider_post_id}";
    }
}
