<?php

namespace App\Logic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Logic\Concerns\UsesAuth;
use App\Logic\Concerns\UsesUserModel;

class UpdateAuthUser extends FormRequest
{
    use UsesAuth;
    use UsesUserModel;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(app(self::getUserClass())->getTable())->ignore(self::getAuthGuard()->id())],
        ];
    }

    public function handle(): void
    {
        $user = self::getUserClass()::findOrFail(self::getAuthGuard()->user()->id);

        $user->update([
            'name' => $this->input('name'),
            'email' => $this->input('email'),
        ]);
    }
}
