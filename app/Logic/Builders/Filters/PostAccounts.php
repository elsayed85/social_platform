<?php

namespace App\Logic\Builders\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use App\Logic\Contracts\Filter;

class PostAccounts implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('accounts', function ($query) use ($value) {
            $query->whereIn('account_id', Arr::wrap($value));
        });
    }
}
