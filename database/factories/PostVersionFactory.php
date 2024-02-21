<?php

namespace Database\Factories;

use App\Logic\Models\Account;
use App\Logic\Models\PostVersion;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostVersionFactory extends Factory
{
    protected $model = PostVersion::class;

    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'is_original' => 0,
            'content' => [
                [
                    "body" => "<div>👋 {$this->faker->paragraph}</div>
                               <div>{$this->faker->paragraph}</div>
                               <div>
                                <a target=\"_blank\" rel=\"noopener noreferrer nofollow\" href=\"https://mixpost.app\">https://mixpost.app</a>
                               </div>",
                    "media" => [3, 7, 5]
                ]
            ]
        ];
    }
}
