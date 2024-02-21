<?php

namespace Database\Factories;

use App\Logic\Models\Account;
use App\Logic\Models\Audience;
use Illuminate\Database\Eloquent\Factories\Factory;

class AudienceFactory extends Factory
{
    protected $model = Audience::class;

    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'total' => $this->faker->numberBetween(1, 100000),
            'date' => $this->faker->dateTimeBetween('-90 days'),
        ];
    }
}
