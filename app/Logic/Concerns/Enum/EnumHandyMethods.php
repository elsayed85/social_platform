<?php

namespace App\Logic\Concerns\Enum;

trait EnumHandyMethods
{
    public static function fromName(string $name)
    {
        return constant("self::$name");
    }
}
