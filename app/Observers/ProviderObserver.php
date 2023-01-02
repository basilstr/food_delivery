<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class ProviderObserver
{
    public function created()
    {
        Cache::forget('api_providers');
        Cache::forget('api_provider_food');
    }

    public function updated()
    {
        Cache::forget('api_providers');
        Cache::forget('api_provider_food');
    }
}
