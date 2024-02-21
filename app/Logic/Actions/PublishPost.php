<?php

namespace App\Logic\Actions;

use Illuminate\Support\Facades\Bus;
use App\Logic\Jobs\AccountPublishPostJob;
use App\Logic\Models\Post;

class PublishPost
{
    public function __invoke(Post $post): void
    {
        if ($post->isScheduleProcessing()) {
            return;
        }

        $post->setScheduleProcessing();

        $jobs = $post->accounts->map(function ($account) use ($post) {
            return new AccountPublishPostJob($account, $post);
        });

        Bus::batch($jobs)
            ->allowFailures()
            ->finally(function () use ($post) {
                if ($post->hasErrors()) {
                    $post->setFailed();
                    return;
                }

                $post->setPublished();
            })
            ->onQueue('publish-post')
            ->dispatch();
    }
}
