<?php

namespace Database\Factories;

use App\Logic\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        return [
            'name' => $this->faker->domainName,
            'credentials' => ['client_id' => $this->faker->randomDigit(), 'client_secret' => $this->faker->randomDigit()]
        ];
    }
}
