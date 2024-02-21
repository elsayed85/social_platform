<?php

namespace App\Logic\Reports;

use App\Logic\Abstracts\Report;
use App\Logic\Models\Account;

class FacebookGroupReports extends Report
{
    public function __invoke(Account $account, string $period): array
    {
        return [
            'metrics' => [],
            'audience' => $this->audience($account, $period)
        ];
    }

    protected function metrics(Account $account, string $period): array
    {
        return [];
    }
}
