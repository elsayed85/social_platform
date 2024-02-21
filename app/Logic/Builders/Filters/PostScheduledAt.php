<?php

namespace App\Logic\Builders\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use App\Logic\Contracts\Filter;

class PostScheduledAt implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        $date = Carbon::parse($value['date']);

        if ($value['calendar_type'] === 'month') {
            return $builder->whereYear('scheduled_at', $date->year)
                ->whereMonth('scheduled_at', $date->month);
        }

        if ($value['calendar_type'] === 'week') {
            return $builder->whereDate('scheduled_at', '>=', $date->startOfWeek()->toDateString())
                ->whereDate('scheduled_at', '<=', $date->endOfWeek()->toDateString());
        }

        if ($value['calendar_type'] === 'day') {
            return $builder->whereDate('scheduled_at', $date->toDateString());
        }

        return $builder;
    }
}
