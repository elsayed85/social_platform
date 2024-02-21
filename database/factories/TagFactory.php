<?php

namespace Database\Factories;

use App\Logic\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'name' => $this->faker->domainName,
            'hex_color' => Str::after($this->faker->hexColor, '#')
        ];
    }
}
