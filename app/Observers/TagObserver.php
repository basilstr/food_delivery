<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class TagObserver
{
    public function created()
    {
        Cache::forget('api_tag');
        Cache::forget('api_provider_food');
    }

    public function updated()
    {
        Cache::forget('api_tag');
        Cache::forget('api_provider_food');
    }
}
