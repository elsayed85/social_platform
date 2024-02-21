<?php

namespace Database\Factories;

use App\Logic\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition()
    {
        $size = $this->faker->randomDigit();

        return [
            'name' => $this->faker->domainName,
            'mime_type' => $this->faker->mimeType(),
            'disk' => 'public',
            'path' => '',
            'size' => $size,
            'size_total' => $size,
            'conversions' => []
        ];
    }
}
