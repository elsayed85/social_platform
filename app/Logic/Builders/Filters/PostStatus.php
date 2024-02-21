<?php

namespace App\Logic\Builders\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Logic\Contracts\Filter;
use App\Logic\Enums\PostStatus as PostStatusEnum;

class PostStatus implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        $status = match ($value) {
            'draft' => PostStatusEnum::DRAFT->value,
            'scheduled' => PostStatusEnum::SCHEDULED->value,
            'published' => PostStatusEnum::PUBLISHED->value,
            'failed' => PostStatusEnum::FAILED->value,
            default => null
        };

        if ($status === null) {
            return $builder;
        }

        return $builder->where('status', $status);
    }
}
