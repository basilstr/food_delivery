<?php

namespace Database\Factories;

use App\Models\Finance\Account;
use App\Models\Finance\SubAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'city_id' => 1,
            'address' => $this->faker->address(),
            'account_id' => Account::get()->random()->id,
            'about' => $this->faker->realText,
            'rating' => $this->faker->randomElement([1,2,3,4,5]),
        ];
    }
}
