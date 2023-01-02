<?php

namespace Database\Factories\Foods;

use App\Models\Foods\Food;
use App\Models\Tag;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodTagFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'food_id' => Food::get()->random()->id,
            'tag_id' => Tag::get()->random()->id,
        ];
    }
}
