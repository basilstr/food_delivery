<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Http\Resources\FoodsResource;
use App\Models\Foods\Food;
use App\Models\Permanent\TypeFoodIngredient;
use Illuminate\Support\Facades\Cache;

// https://www.youtube.com/watch?v=FjhcY5GbwfE
class FoodController extends Controller
{
    public function foods($city_id)
    {
        // обнуляється кеш тут - App\Observers;
        return FoodsResource::collection(Food::join('providers', 'providers.id', '=', 'food.provider_id')
            ->where('providers.city_id', $city_id)
            ->whereIn('food.status', [Food::SCHEDULE_ACTIVE, Food::ACTIVE])
            ->whereIn('food.food_ingredient', [TypeFoodIngredient::FOOD, TypeFoodIngredient::FOOD_INGREDIENT])
            ->orderBy('food.sort')
            ->get('food.*'));
    }

    public function food($id)
    {
        return new FoodResource(Food::findOrFail($id));
    }

    public function foodsTag($city_id, $id)
    {
        return FoodsResource::collection(
            Food::select('food.*')
                ->join('providers as pr', 'pr.id', '=', 'food.provider_id')
                ->join('food_tags as ft', 'ft.food_id', '=', 'food.id')
                ->join('tags', 'tags.id', '=', 'ft.tag_id')
                ->where('ft.tag_id', $id)
                ->where('pr.city_id', $city_id)
                ->groupBy('food.id')
                ->get()
        );
    }
}
