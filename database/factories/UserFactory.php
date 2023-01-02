<?php

namespace Database\Factories;

use App\Models\Finance\Account;
use App\Models\Permanent\Cities;
use App\Models\Permanent\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return array(
            'login' => $this->faker->unique()->lexify(),
            'name' => $this->faker->name(),
            'role' => $this->faker->randomElement(Role::getListKey()),
            'status' => 1,
            'city_id' => $this->faker->randomElement(Cities::getListKey()),
            'password' => '$2y$10$81xoBGD.6doK2iFqT/dyHOUBQfjpJt.tc9uS8dHdNQjKpo.3sGFbu', // password => 1
            'remember_token' => Str::random(10),
        );
    }
}
