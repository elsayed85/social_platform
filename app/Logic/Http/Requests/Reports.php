<?php

namespace App\Logic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Logic\Reports\FacebookGroupReports;
use App\Logic\Reports\FacebookPageReports;
use App\Logic\Reports\MastodonReports;
use App\Logic\Reports\TwitterReports;
use App\Logic\Contracts\ProviderReports;
use App\Logic\Models\Account;

class Reports extends FormRequest
{
    public function rules(): array
    {
        return [
            'account_id' => ['required', 'integer', 'exists:mixpost_accounts,id'],
            'period' => ['required', 'string', Rule::in(['7_days', '30_days', '90_days'])]
        ];
    }

    public function handle(): array
    {
        $account = Account::find($this->get('account_id'));

        $providerReports = match ($account->provider) {
            'twitter' => TwitterReports::class,
            'facebook_page' => FacebookPageReports::class,
            'facebook_group' => FacebookGroupReports::class,
            'mastodon' => MastodonReports::class,
            default => null
        };

        if (!$providerReports) {
            return [];
        }

        $providerReports = (new $providerReports());

        if (!$providerReports instanceof ProviderReports) {
            throw new \Exception('The provider reports must be an instance of ProviderReports');
        }

        return $providerReports($account, $this->get('period', ''));
    }
}
