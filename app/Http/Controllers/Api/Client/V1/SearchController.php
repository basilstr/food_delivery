<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodByNameResource;
use App\Http\Resources\SearchResource;
use App\Models\Foods\Food;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search($city_id, Request $request)
    {
        $q = $request->input('q');
        $query = Food::join('providers', 'providers.id', '=', 'food.provider_id')
            ->where('food.name', 'like', "%{$q}%")
            ->where('providers.city_id', $city_id)
            ->selectRaw('food.*, count(*) as total')
            ->limit(10);
        $query->groupBy('food.name');

        return SearchResource::collection($query->get(''));
    }

    public function foodbyname($city_id, Request $request)
    {
        $q = $request->input('q');
        $query = Food::join('providers', 'providers.id', '=', 'food.provider_id')
            ->where('food.name', 'like', "%{$q}%")
            ->where('providers.city_id', $city_id)
            ->selectRaw('food.*, count(*) as total')
            ->limit(10);
        $query->groupBy('food.id');

        return FoodByNameResource::collection($query->get(''));
    }
}
