<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;
use App\Models\Foods\Food;
use App\Models\Foods\Ingredient;
use App\Models\Permanent\TypeFoodIngredient;
use Illuminate\Support\Facades\Cache;

// https://www.youtube.com/watch?v=FjhcY5GbwfE
class IngredientController extends Controller
{
    public function ingredients($id)
    {
        // обнуляється кеш тут - App\Observers;
        $q = IngredientResource::collection(Ingredient::join('food', 'food.id', '=', 'ingredients.ingredient_food_id')
            ->where('ingredients.parent_food_id', $id)
            ->whereIn('ingredients.status', [Food::SCHEDULE_ACTIVE, Food::ACTIVE])
            ->get('ingredients.*'));
        return $q;
    }
}
