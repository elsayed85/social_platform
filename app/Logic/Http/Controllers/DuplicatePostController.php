<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Logic\Enums\PostStatus;
use App\Logic\Models\Post;

class DuplicatePostController extends Controller
{
    public function __invoke(Post $post): RedirectResponse
    {
        DB::transaction(function () use ($post) {
            $newPost = Post::create([
                'status' => PostStatus::DRAFT
            ]);

            $newPost->accounts()->attach($post->accounts->pluck('id'));
            $newPost->tags()->attach($post->tags->pluck('id'));
            $newPost->versions()->createMany($post->versions->map(function ($version) {
                return [
                    'account_id' => $version->account_id,
                    'is_original' => $version->is_original,
                    'content' => $version->content,
                ];
            })->toArray());
        });

        return redirect()->route('social.posts.index');
    }
}