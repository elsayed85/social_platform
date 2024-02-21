<?php

namespace App\Logic\Commands;

use Illuminate\Console\Command;
use App\Logic\Actions\CreateMastodonApp as CreateMastodonAppAction;
use App\Logic\Facades\Services;

class CreateMastodonApp extends Command
{
    public $signature = 'app:create-mastodon-app {server}';

    public $description = 'Create new mastodon application for a server';

    public function handle(): int
    {
        $server = $this->argument('server');

        $serviceName = "mastodon.$server";

        if (Services::get($serviceName)) {
            if (!$this->confirm('Are you sure you want to create a new application for this server?')) {
                return self::FAILURE;
            }

            $this->comment("This action may have a negative impact on scheduled posts and authenticated accounts with Mastodon on $server server.");

            if (!$this->confirm('I confirm that I understand the risks and I will reauthenticate all accounts on this Mastodon server.')) {
                return self::FAILURE;
            }
        }

        $result = (new CreateMastodonAppAction())($server);

        if (isset($result['error'])) {
            $this->error($result['error']);

            return self::FAILURE;
        }

        $this->info("A new application for the $server server has been created!");

        return self::SUCCESS;
    }
}
