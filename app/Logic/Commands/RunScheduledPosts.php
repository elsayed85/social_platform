<?php

namespace App\Logic\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Logic\Actions\PublishPost;
use App\Logic\Enums\PostScheduleStatus;
use App\Logic\Enums\PostStatus;
use App\Logic\Models\Post;

class RunScheduledPosts extends Command
{
    public $signature = 'app:run-scheduled-posts';

    public $description = 'Scan & run scheduled posts';

    public function handle(): int
    {
        Post::with('accounts')
            ->where('status', PostStatus::SCHEDULED->value)
            ->where('schedule_status', PostScheduleStatus::PENDING->value)
            ->where('scheduled_at', '<=', Carbon::now()->utc())
            ->each(function (Post $post) {
                (new PublishPost())($post);
            });

        return self::SUCCESS;
    }
}
