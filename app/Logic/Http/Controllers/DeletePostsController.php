<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Logic\Actions\RedirectAfterDeletedPost;
use App\Logic\Models\Post;

class DeletePostsController extends Controller
{
    public function __invoke(Request $request, RedirectAfterDeletedPost $redirectAfterPostDeleted): RedirectResponse
    {
        Post::whereIn('id', $request->input('posts'))->delete();

        return $redirectAfterPostDeleted($request);
    }
}
