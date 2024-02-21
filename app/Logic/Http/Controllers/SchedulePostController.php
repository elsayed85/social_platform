<?php

namespace App\Logic\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Logic\Facades\Settings;
use App\Logic\Http\Requests\SchedulePost;
use App\Logic\Util;

class SchedulePostController extends Controller
{
    public function __invoke(SchedulePost $schedulePost): JsonResponse
    {
        $schedulePost->handle();

        $scheduledAt = $schedulePost->getDateTime()->tz(Settings::get('timezone'))->format("D, M j, " . Util::timeFormat());

        return response()->json("The post has been scheduled.\n$scheduledAt");
    }
}
