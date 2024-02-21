<?php

namespace App\Logic\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Logic\Models\FacebookInsight;
use App\Logic\Models\ImportedPost;

class DeleteOldData extends Command
{
    public $signature = 'app:delete-old-data';

    public $description = "Delete old data from social service providers";

    public function handle(): int
    {
        ImportedPost::where('created_at', '<', Carbon::now()->subDays(95)->toDateString())->delete();
        FacebookInsight::where('date', '<', Carbon::now()->subDays(95)->toDateString())->delete();

        return self::SUCCESS;
    }
}
