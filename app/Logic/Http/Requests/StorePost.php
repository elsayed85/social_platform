<?php

namespace App\Logic\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Logic\Enums\PostStatus;
use App\Logic\Models\Post;
use App\Logic\Util;

class StorePost extends PostFormRequest
{
    public function handle()
    {
        return DB::transaction(function () {
            $record = Post::create([
                'status' => PostStatus::DRAFT,
                'scheduled_at' => $this->scheduledAt() ? Util::convertTimeToUTC($this->scheduledAt()) : null
            ]);

            $record->accounts()->attach($this->input('accounts', []));
            $record->tags()->attach($this->input('tags'));
            $record->versions()->createMany($this->input('versions'));

            return $record;
        });
    }
}
