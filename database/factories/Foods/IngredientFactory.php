<?php

namespace Database\Factories\Foods;

use App\Models\Foods\Food;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_food_id' => Food::get()->random()->id,
            'ingredient_food_id' => Food::whereIn('food_ingredient', [2,3])->get()->random()->id,
            'weight' => $this->faker->numberBetween(1, 1000),
            'amount' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 1, 500),
            'price_package' => $this->faker->randomFloat(2, 1, 500),
            'can_change' => $this->faker->numberBetween(1, 3),
            'type_change' => $this->faker->numberBetween(1, 3),
        ];
    }
}
