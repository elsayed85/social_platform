<?php

namespace App\Logic\Concerns\Job;

use App\Logic\Support\Log;
use App\Logic\Support\SocialProviderResponse;

trait SocialProviderJobFail
{
    public function makeFail(SocialProviderResponse $response): void
    {
        Log::error($this->job->payload()['displayName'], array_merge($response->context(), ['payload' => $this->job->payload()]));

        $this->fail();
    }
}
