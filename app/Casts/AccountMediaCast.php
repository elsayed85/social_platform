<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AccountMediaCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return json_decode($value, true);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!isset($value['disk']) && !isset($value['path'])) {
            return null;
        }

        return json_encode([
            'disk' => $value['disk'],
            'path' => $value['path']
        ]);
    }
}
