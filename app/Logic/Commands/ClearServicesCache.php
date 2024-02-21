<?php

namespace App\Logic\Commands;

use Illuminate\Console\Command;
use App\Logic\Facades\Services;

class ClearServicesCache extends Command
{
    public $signature = 'app:clear-services-cache';

    public $description = 'Clear the services from cache';

    public function handle(): int
    {
        Services::forgetAll();

        $this->info('Cache services has been cleared!');

        return self::SUCCESS;
    }
}
