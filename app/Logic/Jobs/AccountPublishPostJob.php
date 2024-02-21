<?php

namespace App\Logic\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Logic\Actions\AccountPublishPost;
use App\Logic\Concerns\Job\HasSocialProviderJobRateLimit;
use App\Logic\Models\Account;
use App\Logic\Models\Post;

class AccountPublishPostJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use HasSocialProviderJobRateLimit;

    public $deleteWhenMissingModels = true;

    public Account $account;
    public Post $post;

    public function __construct(Account $account, Post $post)
    {
        $this->account = $account;
        $this->post = $post;
    }

    public function handle(AccountPublishPost $accountPublishPost): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        if ($this->post->isInHistory()) {
            return;
        }

        if ($retryAfter = $this->rateLimitExpiration()) {
            $this->release($retryAfter);

            return;
        }

        $response = $accountPublishPost($this->account, $this->post);

        if ($response->hasExceededRateLimit()) {
            $this->storeRateLimitExceeded($response->retryAfter(), $response->isAppLevel());
            $this->release($response->retryAfter());

            return;
        }

        if ($response->rateLimitAboutToBeExceeded()) {
            $this->storeRateLimitExceeded($response->retryAfter(), $response->isAppLevel());
        }

        if ($response->hasError()) {
            // We are deleting this job from queue because all info about the failed post is in the `mixpost_post_accounts` table.
            $this->delete();
        }
    }
}
