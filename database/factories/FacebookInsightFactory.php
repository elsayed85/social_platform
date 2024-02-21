<?php

namespace Database\Factories;

use App\Logic\Enums\FacebookInsightType;
use App\Logic\Models\Account;
use App\Logic\Models\FacebookInsight;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacebookInsightFactory extends Factory
{
    protected $model = FacebookInsight::class;

    public function definition()
    {
        return [
            'account_id' => Account::factory()->state([
                'provider' => 'facebook_page'
            ]),
            'type' => FacebookInsightType::PAGE_POSTS_IMPRESSIONS,
            'value' => $this->faker->randomDigit(),
            'date' => $this->faker->dateTimeBetween('-90 days')
        ];
    }
}
