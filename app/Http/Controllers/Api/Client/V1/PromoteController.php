<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotesResource;
use App\Models\Foods\Food;
use Illuminate\Support\Facades\Cache;

// https://www.youtube.com/watch?v=FjhcY5GbwfE
class PromoteController extends Controller
{
    public function promotes($city_id)
    {
        // обнуляється кеш тут - App\Observers;
        return PromotesResource::collection(Food::whereRelation('provider', 'city_id', '=', 1)
            ->whereIn('status', [Food::SCHEDULE_ACTIVE, Food::ACTIVE])
            ->whereIn('promote_status', [Food::SCHEDULE_ACTIVE, Food::ACTIVE])
            ->get());
    }
}
