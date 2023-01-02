<?php

namespace Database\Factories\Finance;

use App\Models\Finance\Account;
use App\Models\Permanent\TypeAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::get()->random()->id,
            'type_account_id' => array_rand(TypeAccount::getListKey()),
            'total' =>$this->faker->randomFloat(7,0,5000),
        ];
    }
}
