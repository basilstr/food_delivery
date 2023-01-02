<?php

namespace Database\Factories;

use App\Models\Foods\Food;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
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
            'description' => $this->faker->name(),
        ];
    }
}
