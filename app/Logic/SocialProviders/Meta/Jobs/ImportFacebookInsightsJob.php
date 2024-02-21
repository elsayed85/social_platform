<?php

namespace App\Logic\SocialProviders\Meta\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Logic\Concerns\Job\HasSocialProviderJobRateLimit;
use App\Logic\Concerns\Job\SocialProviderJobFail;
use App\Logic\Concerns\UsesSocialProviderManager;
use App\Logic\Enums\FacebookInsightType;
use App\Logic\Models\Account;
use App\Logic\Models\FacebookInsight;
use App\Logic\SocialProviders\Meta\FacebookPageProvider;
use App\Logic\Support\SocialProviderResponse;

class ImportFacebookInsightsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use UsesSocialProviderManager;
    use HasSocialProviderJobRateLimit;
    use SocialProviderJobFail;

    public $deleteWhenMissingModels = true;

    public Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function handle(): void
    {
        if ($retryAfter = $this->rateLimitExpiration()) {
            $this->release($retryAfter);

            return;
        }

        /**
         * @see FacebookPageProvider
         * @var SocialProviderResponse $response
         */
        $response = $this->connectProvider($this->account)->getPageInsights();

        if ($response->hasExceededRateLimit()) {
            $this->storeRateLimitExceeded($response->retryAfter(), $response->isAppLevel());
            $this->release($response->retryAfter());

            return;
        }

        if ($response->rateLimitAboutToBeExceeded()) {
            $this->storeRateLimitExceeded($response->retryAfter(), $response->isAppLevel());
        }

        if ($response->hasError()) {
            $this->makeFail($response);

            return;
        }

        $insights = $response->context()['data'];

        foreach ($insights as $insight) {
            $this->importInsights(FacebookInsightType::fromName(Str::upper($insight['name'])), $insight['values']);
        }
    }

    protected function importInsights(FacebookInsightType $type, array $items): void
    {
        $data = Arr::map($items, function ($item) use ($type) {
            return [
                'account_id' => $this->account->id,
                'type' => $type,
                'date' => Carbon::parse($item['end_time'], 'UTC')->toDateString(),
                'value' => $item['value'],
            ];
        });

        FacebookInsight::upsert($data, ['account_id', 'type', 'date'], ['value']);
    }
}
