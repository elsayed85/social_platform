<?php

namespace App\Logic\Builders\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Logic\Contracts\Filter;

class PostKeyword implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('versions', function ($query) use ($value) {
            $query->whereRaw('LOWER(content->>"$[*].body") LIKE  "%' . Str::lower($value) . '%"');
        });
    }
}
