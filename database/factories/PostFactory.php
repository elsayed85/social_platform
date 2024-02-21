<?php

namespace Database\Factories;

use App\Logic\Enums\PostScheduleStatus;
use App\Logic\Enums\PostStatus;
use App\Logic\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $statuses = PostStatus::cases();

        $status = Arr::random($statuses);

        $scheduled = now()->addDays(rand(1, 30));

        return [
            'status' => $status->value,
            'schedule_status' => $status === PostStatus::PUBLISHED ? PostScheduleStatus::PROCESSED : PostScheduleStatus::PENDING,
            'scheduled_at' => $status !== PostStatus::DRAFT ? $scheduled : null,
            'published_at' => $status === PostStatus::PUBLISHED ? $scheduled->addHours(rand(0, 5)) : null,
        ];
    }

    public function withScheduledAtBetweenDates($start, $end)
    {
        return $this->state(function (array $attributes) use ($start, $end) {
            return [
                'scheduled_at' => $this->faker->dateTimeBetween($start, $end),
            ];
        });
    }
}
