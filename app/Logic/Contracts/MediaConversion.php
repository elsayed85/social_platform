<?php

namespace App\Logic\Contracts;

use App\Logic\Support\MediaConversionData;

interface MediaConversion
{
    public function getEngineName(): string;

    public function getPath(): string;

    public function canPerform(): bool;

    public function handle(): MediaConversionData|null;
}
