<?php

namespace App\Logic;

use App\Logic\Abstracts\SocialProviderManager as SocialProviderManagerAbstract;
use App\Logic\Facades\Services;
use App\Logic\SocialProviders\Meta\FacebookGroupProvider;
use App\Logic\SocialProviders\Meta\FacebookPageProvider;
use App\Logic\SocialProviders\Twitter\TwitterProvider;
use App\Logic\SocialProviders\Mastodon\MastodonProvider;

class SocialProviderManager extends SocialProviderManagerAbstract
{
    protected function connectTwitterProvider()
    {
        $config = Services::get('twitter');

        $config['redirect'] = route('social.callbackSocialProvider', ['provider' => 'twitter']);

        return $this->buildConnectionProvider(TwitterProvider::class, $config);
    }

    protected function connectFacebookPageProvider()
    {
        $config = Services::get('facebook');

        $config['redirect'] = route('social.callbackSocialProvider', ['provider' => 'facebook_page']);

        return $this->buildConnectionProvider(FacebookPageProvider::class, $config);
    }

    protected function connectFacebookGroupProvider()
    {
        $config = Services::get('facebook');

        $config['redirect'] = route('social.callbackSocialProvider', ['provider' => 'facebook_group']);

        return $this->buildConnectionProvider(FacebookGroupProvider::class, $config);
    }

    protected function connectMastodonProvider()
    {
        $request = $this->container->request;
        $sessionServerKey = "{$this->config->get('social.cache_prefix')}.mastodon_server";

        if ($request->route() && $request->route()->getName() === 'social.accounts.add') {
            $serverName = $this->container->request->input('server');
            $request->session()->put($sessionServerKey, $serverName); // We keep the server name in the session. We'll need it in the callback
        } else if ($request->route() && $request->route()->getName() === 'social.callbackSocialProvider') {
            $serverName = $request->session()->get($sessionServerKey);
        } else {
            $serverName = $this->values['data']['server']; // Get the server value that have been set on SocialProviderManager::connect($provider, array $values = [])
        }

        $config = Services::get("mastodon.$serverName");

        $config['redirect'] = route('social.callbackSocialProvider', ['provider' => 'mastodon']);
        $config['values'] = [
            'data' => ['server' => $serverName]
        ];

        return $this->buildConnectionProvider(MastodonProvider::class, $config);
    }
}
