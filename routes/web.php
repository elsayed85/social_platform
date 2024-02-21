<?php

use App\Logic\Facades\SocialProviderManager;
use Illuminate\Support\Facades\Route;
use App\Logic\Http\Controllers\AccountEntitiesController;
use App\Logic\Http\Controllers\AccountsController;
use App\Logic\Http\Controllers\AddAccountController;
use App\Logic\Http\Controllers\AuthenticatedController;
use App\Logic\Http\Controllers\CalendarController;
use App\Logic\Http\Controllers\CallbackSocialProviderController;
use App\Logic\Http\Controllers\CreateMastodonAppController;
use App\Logic\Http\Controllers\DashboardController;
use App\Logic\Http\Controllers\UpdateAuthUserController;
use App\Logic\Http\Controllers\UpdateAuthUserPasswordController;
use App\Logic\Http\Controllers\ProfileController;
use App\Logic\Http\Controllers\ReportsController;
use App\Logic\Http\Controllers\DeletePostsController;
use App\Logic\Http\Controllers\DuplicatePostController;
use App\Logic\Http\Controllers\MediaController;
use App\Logic\Http\Controllers\MediaDownloadExternalController;
use App\Logic\Http\Controllers\MediaFetchGifsController;
use App\Logic\Http\Controllers\MediaFetchStockController;
use App\Logic\Http\Controllers\MediaFetchUploadsController;
use App\Logic\Http\Controllers\MediaUploadFileController;
use App\Logic\Http\Controllers\PostsController;
use App\Logic\Http\Controllers\SchedulePostController;
use App\Logic\Http\Controllers\ServicesController;
use App\Logic\Http\Controllers\SettingsController;
use App\Logic\Http\Controllers\TagsController;
use App\Logic\Http\Middleware\Auth as MixpostAuthMiddleware;
use App\Logic\Http\Middleware\HandleInertiaRequests;

Route::get('callback/{provider}', CallbackSocialProviderController::class)->name('social.callbackSocialProvider');


Route::get('/', function () {
    $providerName = 'FacebookPage';
    $provider = SocialProviderManager::connect($providerName);

    $url = $provider->getAuthUrl();

    dd($url);
});
