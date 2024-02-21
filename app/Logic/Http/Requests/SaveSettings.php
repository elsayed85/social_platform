<?php

namespace App\Logic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Logic\Facades\Settings as SettingsFacade;
use App\Logic\Models\Setting as SettingModel;

class SaveSettings extends FormRequest
{
    public function rules(): array
    {
        return SettingsFacade::rules();
    }

    public function handle(): void
    {
        $schema = SettingsFacade::form();

        foreach ($schema as $name => $defaultPayload) {
            $payload = $this->input($name, $defaultPayload);

            SettingModel::updateOrCreate(['name' => $name], ['payload' => $payload]);

            SettingsFacade::put($name, $payload);
        }
    }
}
