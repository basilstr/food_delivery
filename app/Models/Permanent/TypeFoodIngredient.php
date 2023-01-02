<?php

namespace App\Models\Permanent;

use App\Models\BaseModels\BasePermanentModel;

class TypeFoodIngredient extends BasePermanentModel
{
    const FOOD              = 1;
    const INGREDIENT        = 2;
    const FOOD_INGREDIENT   = 3;

    protected $attributes = [
        self::FOOD => 'Блюдо',
        self::INGREDIENT => 'Інгредієнт',
        self::FOOD_INGREDIENT => 'Блюдо+Інгредієнт',
    ];

}
