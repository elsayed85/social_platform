<?php

namespace App\Logic\Commands;

use Illuminate\Console\Command;
use App\Logic\Concerns\AccountsOption;
use App\Logic\SocialProviders\Mastodon\Jobs\ProcessMastodonMetricsJob;
use App\Logic\SocialProviders\Twitter\Jobs\ProcessTwitterMetricsJob;

class ProcessMetrics extends Command
{
    use AccountsOption;

    public $signature = 'app:process-metrics {--accounts=}';

    public $description = 'Process metrics for the social providers';

    public function handle(): int
    {
        $this->accounts()->each(function ($account) {
            $job = match ($account->provider) {
                'twitter' => ProcessTwitterMetricsJob::class,
                'mastodon' => ProcessMastodonMetricsJob::class,
                default => null,
            };

            if ($job) {
                $job::dispatch($account);
            }
        });

        return self::SUCCESS;
    }
}
