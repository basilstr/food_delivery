<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class FoodObserver
{
    public function created()
    {
        Cache::forget('api_food');
        Cache::forget('api_provider_food');
    }

    public function updated()
    {
        Cache::forget('api_food');
        Cache::forget('api_provider_food');
    }
}
