<?php

namespace App\Logic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Logic\Models\Media;

class DeleteMedia extends FormRequest
{
    public function rules(): array
    {
        return [
            'items' => ['required', 'array']
        ];
    }

    public function handle()
    {
        foreach ($this->input('items') as $id) {
            $media = Media::find($id);

            if (!$media) {
                continue;
            }

            $media->deleteFiles();
            $media->delete();
        }
    }
}
