<?php

use App\Logic\Facades\SocialProviderManager;
use App\Logic\Http\Controllers\CallbackSocialProviderController;
use Illuminate\Support\Facades\Route;

Route::get('callback/{provider}', CallbackSocialProviderController::class)->name('social.callbackSocialProvider');


Route::get('/', function () {
    $providerName = 'FacebookPage';
    $provider = SocialProviderManager::connect($providerName);

    $url = $provider->getAuthUrl();

    dd($url);
});
