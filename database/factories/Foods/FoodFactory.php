<?php

namespace Database\Factories\Foods;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
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
            'provider_id' => Provider::get()->random()->id,
            'type_food' => $this->faker->numberBetween(1, 2),
            'food_ingredient' => $this->faker->numberBetween(1, 3),
            'description' => $this->faker->realText(),
            'weight' => $this->faker->numberBetween(1, 1000),
            'amount' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 1, 500),
        ];
    }
}
