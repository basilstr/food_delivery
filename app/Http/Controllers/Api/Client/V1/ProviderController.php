<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;

use App\Http\Resources\FoodsResource;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\ProvidersResource;
use App\Models\Foods\Food;
use App\Models\Provider;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

// https://www.youtube.com/watch?v=FjhcY5GbwfE
class ProviderController extends Controller
{
    public function providers($city_id)
    {
        // обнуляється кеш тут - App\Observers;
        return ProvidersResource::collection(Provider::where('city_id', $city_id)
            ->whereIn('status', [Provider::SCHEDULE_ACTIVE, Provider::ACTIVE])
            ->get());
    }

    public function provider($id)
    {
        return new ProviderResource(Provider::findOrFail($id));
    }

    // перелік тегів для блюд конкретного закладу
    public function tags($id)
    {
        $tags = DB::select("SELECT `tags`.`id`, `tags`.`name`
                             FROM `food`, `providers`, `food_tags`, `tags`
                             WHERE `providers`.`id` = ".intval($id)."
                             AND `food`.`provider_id` = `providers`.`id`
                             AND `food`.`status` IN (".implode(',', [Food::SCHEDULE_ACTIVE, Food::ACTIVE]).")
                             AND `food_tags`.`food_id`=`food`.`id`
                             AND `food_tags`.`tag_id`=`tags`.`id`
                             AND `tags`.`status` = ".Tag::VISIBLE."
                             GROUP BY `tags`.`id`;");

        return $tags;
    }

    // перелік блюд закладу, що = $id
    public function foods($id)
    {
        $provider = Provider::find($id);
        if($provider) {
            return FoodsResource::collection(Provider::find($id)->foods()->get());
        }
        return [];
    }
}
