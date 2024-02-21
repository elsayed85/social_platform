<?php

namespace App\Logic\ServiceForm;

use App\Logic\Abstracts\ServiceForm;

class TenorServiceForm extends ServiceForm
{
    static function form(): array
    {
        return [
            'client_id' => ''
        ];
    }

    public static function rules(): array
    {
        return [
            "client_id" => ['required']
        ];
    }

    public static function messages(): array
    {
        return [
            'client_id' => 'The API Key is required.'
        ];
    }
}
