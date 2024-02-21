<?php

namespace App\Logic\Abstracts;

use App\Logic\Contracts\ServiceForm as ServiceFormRulesInterface;

abstract class ServiceForm implements ServiceFormRulesInterface
{
    /**
     * The attributes that should be considered as an additional configuration.
     */
    public static array $configs = [];
}
