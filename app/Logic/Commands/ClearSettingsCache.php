<?php

namespace App\Logic\Commands;

use Illuminate\Console\Command;
use App\Logic\Facades\Settings;

class ClearSettingsCache extends Command
{
    public $signature = 'app:clear-settings-cache';

    public $description = 'Clear the settings from cache';

    public function handle(): int
    {
        Settings::forgetAll();

        $this->info('Cache settings has been cleared!');

        return self::SUCCESS;
    }
}
