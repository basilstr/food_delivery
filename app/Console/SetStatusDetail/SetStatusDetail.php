<?php


namespace App\Console\SetStatusDetail;


use App\Models\Foods\Food;
use App\Models\Foods\Ingredient;
use App\Models\Provider;

class SetStatusDetail
{
    public static function makeProvider()
    {
        $providers = Provider::schedule()->get();
        foreach ($providers as $provider){
            $provider->setScheduleActiveStatus('work_schedule', 'status');
        }
    }

    public static function makeFood()
    {
        $foods = Food::schedule()->get();
        foreach ($foods as $food) {
            $food->setScheduleActiveStatus('work_schedule', 'status');
        }
        $foods = Food::promoteSchedule()->get();
        foreach ($foods as $food) {
            $food->setScheduleActiveStatus('promote_schedule', 'promote_status');
        }
    }

    public static function makeIngredient()
    {
        $ingredients = Ingredient::schedule()->get();
        foreach ($ingredients as $ingredient) {
            $ingredient->setScheduleActiveStatus('work_schedule', 'status');
        }
        $ingredients = Ingredient::promoteSchedule()->get();
        foreach ($ingredients as $ingredient) {
            $ingredient->setScheduleActiveStatus('promote_schedule', 'promote_status');
        }
    }
}
