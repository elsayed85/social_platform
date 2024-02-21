<?php

namespace App\Logic\Support;

use Illuminate\Support\Str;
use Spatie\TemporaryDirectory\TemporaryDirectory as BaseTemporaryDirectory;

class MediaTemporaryDirectory
{
    public static function create(): BaseTemporaryDirectory
    {
        return new BaseTemporaryDirectory(static::getTemporaryDirectoryPath());
    }

    protected static function getTemporaryDirectoryPath(): string
    {
        $path = config('social.temporary_directory_path') ?? storage_path('social-media/temp');

        return $path . DIRECTORY_SEPARATOR . Str::random(32);
    }
}
