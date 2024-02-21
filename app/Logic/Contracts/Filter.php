<?php

namespace App\Logic\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    public static function apply(Builder $builder, $value): Builder;
}
