<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Courier;
use App\Models\Foods\Food;
use App\Models\Foods\Ingredient;
use App\Models\Provider;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-user', function (User $user, User $userUpdate) {
            if($user->city_id && $user->city_id != $userUpdate->city_id) return false;
            return true;
        });

        Gate::define('update-client', function (User $user, Client $client) {
            if($user->city_id && $user->city_id != $client->city_id) return false;
            return true;
        });

        Gate::define('update-courier', function (User $user, Courier $courier) {
            if($user->city_id && $user->city_id != $courier->city_id) return false;
            return true;
        });

        Gate::define('update-provider', function (User $user, Provider $provider) {
            if($user->city_id && $user->city_id != $provider->city_id) return false;
            return true;
        });

        Gate::define('update-food', function (User $user, Food $food) {
            if($user->city_id && $user->city_id != $food->provider->city_id) return false;
            return true;
        });

        Gate::define('update-ingredient', function (User $user, Ingredient $ingredient) {
            if($user->city_id && $user->city_id != $ingredient->parentIngredient->provider->city_id) return false;
            return true;
        });
    }
}
