<?php

namespace Database\Factories;

use App\Logic\Models\Account;
use App\Logic\Models\Metric;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetricFactory extends Factory
{
    protected $model = Metric::class;

    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'data' => [
                'likes' => $this->faker->randomDigit(),
                'retweets' => $this->faker->randomDigit(),
                'impressions' => $this->faker->randomDigit()
            ],
            'date' => $this->faker->dateTimeBetween('-90 days')
        ];
    }
}
