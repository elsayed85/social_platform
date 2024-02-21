<?php

namespace App\Logic\Commands;

use Illuminate\Console\Command;
use App\Logic\Concerns\AccountsOption;
use App\Logic\SocialProviders\Mastodon\Jobs\ImportMastodonFollowersJob;
use App\Logic\SocialProviders\Meta\Jobs\ImportFacebookGroupMembersJob;
use App\Logic\SocialProviders\Meta\Jobs\ImportFacebookPageFollowersJob;
use App\Logic\SocialProviders\Twitter\Jobs\ImportTwitterFollowersJob;

class ImportAccountAudience extends Command
{
    use AccountsOption;

    public $signature = 'app:import-account-audience {--accounts=}';

    public $description = 'Import audience(count of followers, fans...etc.) for the social providers';

    public function handle(): int
    {
        $this->accounts()->each(function ($account) {
            $job = match ($account->provider) {
                'twitter' => ImportTwitterFollowersJob::class,
                'facebook_page' => ImportFacebookPageFollowersJob::class,
                'facebook_group' => ImportFacebookGroupMembersJob::class,
                'mastodon' => ImportMastodonFollowersJob::class,
                default => null,
            };

            if ($job) {
                $job::dispatch($account);
            }
        });

        return self::SUCCESS;
    }
}
