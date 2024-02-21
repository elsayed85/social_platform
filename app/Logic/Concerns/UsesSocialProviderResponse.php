<?php

namespace App\Logic\Concerns;

use App\Logic\Enums\SocialProviderResponseStatus;
use App\Logic\Support\SocialProviderResponse;

trait UsesSocialProviderResponse
{
    public function response(
        SocialProviderResponseStatus $status,
        array                        $context,
        bool                         $rateLimitAboutToBeExceeded = false,
        int                          $retryAfter = 0,
        bool                         $isAppLevel = false): SocialProviderResponse
    {
        return new SocialProviderResponse($status, $context, $rateLimitAboutToBeExceeded, $retryAfter, $isAppLevel);
    }
}
