<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use App\Logic\Http\Requests\StoreTag;
use App\Logic\Http\Requests\UpdateTag;
use App\Logic\Models\Tag;

class TagsController extends Controller
{
    public function store(StoreTag $storeTag): RedirectResponse
    {
        $storeTag->handle();

        return redirect()->back();
    }

    public function update(UpdateTag $updateTag): RedirectResponse
    {
        $updateTag->handle();

        return redirect()->back();
    }

    public function destroy($id): RedirectResponse
    {
        Tag::where('id', $id)->delete();

        return redirect()->back();
    }
}
