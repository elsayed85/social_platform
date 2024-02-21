<?php

namespace App\Logic\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Logic\Builders\Filters\ExcludePostStatus;
use App\Logic\Builders\Filters\PostAccounts;
use App\Logic\Builders\Filters\PostKeyword;
use App\Logic\Builders\Filters\PostScheduledAt;
use App\Logic\Builders\Filters\PostTags;
use App\Logic\Builders\Filters\PostStatus;
use App\Logic\Contracts\Query;
use App\Logic\Models\Post;

class PostQuery implements Query
{
    public static function apply(Request $request): Builder
    {
        $query = Post::with('accounts', 'versions', 'tags');

        if ($request->has('status') && $request->get('status') !== null) {
            $query = PostStatus::apply($query, $request->get('status'));
        }

        if ($request->has('exclude_status') && $request->get('exclude_status')) {
            $query = ExcludePostStatus::apply($query, $request->get('exclude_status'));
        }

        if ($request->has('keyword') && $request->get('keyword')) {
            $query = PostKeyword::apply($query, $request->get('keyword'));
        }

        if ($request->has('accounts') && !empty($request->get('accounts'))) {
            $query = PostAccounts::apply($query, $request->get('accounts', []));
        }

        if ($request->has('tags') && !empty($request->get('tags'))) {
            $query = PostTags::apply($query, $request->get('tags', []));
        }

        if ($request->has('date') && !empty($request->get('date')) && preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $request->get('date'))) {
            $query = PostScheduledAt::apply($query, $request->only('calendar_type', 'date'));
        }

        return $query;
    }
}
