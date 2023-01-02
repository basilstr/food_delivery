<?php

namespace Database\Factories\Finance;

use App\Models\Finance\SubAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sub_account_from' => SubAccount::get()->random()->id,
            'total_from' =>$this->faker->randomFloat(7,0,5000),
            'sub_account_to' => SubAccount::get()->random()->id,
            'total_to' =>$this->faker->randomFloat(7,0,5000),
            'sum' =>$this->faker->randomFloat(7,0,5000),
            'description' =>$this->faker->realText(),
        ];
    }
}
