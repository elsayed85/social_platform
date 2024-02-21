<?php

namespace App\Logic\Commands;

use Illuminate\Console\Command;
use App\Logic\Concerns\AccountsOption;
use App\Logic\SocialProviders\Mastodon\Jobs\ImportMastodonPostsJob;
use App\Logic\SocialProviders\Meta\Jobs\ImportFacebookInsightsJob;
use App\Logic\SocialProviders\Twitter\Jobs\ImportTwitterPostsJob;

class ImportAccountData extends Command
{
    use AccountsOption;

    public $signature = 'app:import-account-data {--accounts=}';

    public $description = 'Import data from social service providers';

    public function handle(): int
    {
        $this->accounts()->each(function ($account) {
            $job = match ($account->provider) {
                'twitter' => ImportTwitterPostsJob::class,
                'facebook_page' => ImportFacebookInsightsJob::class,
                'mastodon' => ImportMastodonPostsJob::class,
                default => null,
            };

            if ($job) {
                $job::dispatch($account);
            }
        });

        return self::SUCCESS;
    }
}
