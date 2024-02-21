<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;
use App\Logic\Builders\PostQuery;
use App\Logic\Http\Requests\Calendar;
use App\Logic\Http\Resources\AccountResource;
use App\Logic\Http\Resources\PostResource;
use App\Logic\Http\Resources\TagResource;
use App\Logic\Models\Account;
use App\Logic\Models\Tag;

class CalendarController extends Controller
{
    public function index(Calendar $request): Response
    {
        $request->handle();

        $posts = PostQuery::apply($request)->oldest('scheduled_at')->get();

        return Inertia::render('Calendar', [
            'accounts' => fn() => AccountResource::collection(Account::oldest()->get())->resolve(),
            'tags' => fn() => TagResource::collection(Tag::latest()->get())->resolve(),
            'posts' => fn() => PostResource::collection($posts)->additional([
                'filter' => [
                    'accounts' => Arr::map($request->get('accounts', []), 'intval')
                ]
            ]),
            'type' => $request->type(),
            'selected_date' => $request->selectedDate(),
            'filter' => [
                'keyword' => $request->get('keyword', ''),
                'status' => $request->get('status'),
                'tags' => $request->get('tags', []),
                'accounts' => $request->get('accounts', [])
            ],
        ]);
    }
}
