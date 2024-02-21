<?php

namespace App\Logic\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Logic\Enums\PostStatus;
use App\Logic\Models\Post;

class RedirectAfterDeletedPost
{
    public function __invoke(Request $request): RedirectResponse
    {
        $hasFilterFailedStatus = $request->has('status') && $request->get('status') === Str::lower(PostStatus::FAILED->name);

        if ($hasFilterFailedStatus) {
            if (!Post::failed()->exists()) {
                return redirect()->route('social.posts.index');
            }

            return redirect()->back();
        }

        return redirect()->back();
    }
}
