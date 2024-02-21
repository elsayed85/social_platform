<?php

namespace App\Logic\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Logic\Models\Account;
use App\Logic\Support\MediaUploader;

class UpdateOrCreateAccount
{
    public function __invoke(string $providerName, array $account, array $accessToken): void
    {
        Account::updateOrCreate(
            [
                'provider' => $providerName,
                'provider_id' => $account['id']
            ],
            [
                'name' => $account['name'],
                'username' => $account['username'] ?? null,
                'media' => $this->media($account['image'], $providerName),
                'data' => $account['data'] ?? null,
                'access_token' => $accessToken,
            ]
        );
    }

    protected function media(string|null $imageUrl, string $providerName): array|null
    {
        if (!$imageUrl) {
            return null;
        }

        $info = pathinfo($imageUrl);
        $contents = file_get_contents($imageUrl);
        $file = '/tmp/' . Str::random(32);
        file_put_contents($file, $contents);

        $file = new UploadedFile($file, $info['basename']);
        $path = "mixpost/avatars/$providerName";

        $upload = MediaUploader::fromFile($file)->path($path)->upload();

        return [
            'disk' => $upload['disk'],
            'path' => $upload['path']
        ];
    }
}
