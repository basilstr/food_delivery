<?php

namespace App\Providers;

use App\Models\Foods\Food;
use App\Models\Provider;
use App\Models\Tag;
use App\Observers\FoodObserver;
use App\Observers\ProviderObserver;
use App\Observers\TagObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Provider::observe(ProviderObserver::class);
        Food::observe(FoodObserver::class);
        Tag::observe(TagObserver::class);
    }
}
