<?php

namespace App\Logic\Contracts;

use App\Logic\Models\Account;

interface ProviderReports
{
    public function __invoke(Account $account, string $period): array;
}
