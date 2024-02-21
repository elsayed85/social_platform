<?php

namespace App\Logic\Actions;

use Illuminate\Support\Facades\Http;
use Exception;

class CreateMastodonApp
{
    public function __invoke(string $serverName): array
    {
        $serviceName = "mastodon.$serverName";

        try {
            $credentials = Http::post("https:/$serverName/api/v1/apps", [
                'client_name' => config('app.name'),
                'redirect_uris' => route('social.callbackSocialProvider', ['provider' => 'mastodon']),
                'scopes' => 'read write'
            ])->json();

            if (isset($credentials['error'])) {
                return [
                    'error' => $credentials['error']
                ];
            }

            (new UpdateOrCreateService())($serviceName, $credentials);

            return $credentials;
        } catch (Exception $exception) {
            return [
                'error' => 'This Mastodon server is not responding or does not exist.'
            ];
        }
    }
}
