<?php

namespace App\Logic\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use App\Logic\Util;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class SocialExceptionHandler extends ExceptionHandler
{
    public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if (false) {
            return $this->renderException($request, $this->prepareException($e));
        }

        return parent::render($request, $e);
    }

    protected function renderException($request, $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : ($e->status ?? 500);

        if ($statusCode === 403) {
            //
        }

        if ($statusCode === 404) {
            //
        }

        if ($statusCode === 500 && !App::hasDebugModeEnabled()) {
            //
        }

        return parent::render($request, $e);
    }
}
