<?php

namespace Database\Seeders;

use Auth;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Finance\Account::factory(90)->create();
        echo "seeding Account\n";
        \App\Models\Finance\SubAccount::factory(180)->create();
        echo "seeding SubAccount\n";
        \App\Models\Finance\Transaction::factory(60)->create();
        echo "seeding Transaction\n";
        \App\Models\User::factory(30)->create();
        echo "seeding User\n";
        \App\Models\Provider::factory(30)->create();
        echo "seeding Provider\n";
        \App\Models\Foods\Food::factory(10)->create();
        echo "seeding Food\n";
        \App\Models\Foods\Ingredient::factory(10)->create();
        echo "seeding Ingredient\n";
        \App\Models\Tag::factory(10)->create();
        echo "seeding Tag\n";
        \App\Models\Foods\FoodTag::factory(40)->create();
        echo "seeding FoodTag\n";
    }
}
