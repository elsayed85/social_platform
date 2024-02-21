<?php

namespace App\Logic\Actions;

use App\Logic\Models\Service;

class UpdateOrCreateService
{
    public function __invoke(string $name, array $value): Service
    {
        return Service::updateOrCreate(['name' => $name], [
            'credentials' => $value
        ]);
    }
}
