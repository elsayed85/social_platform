<?php

namespace App\Logic\Concerns;

use App\Logic\Models\User;

trait UsesUserModel
{
    public static function getUserClass(): string
    {
        return config('social.user_model', User::class);
    }
}
