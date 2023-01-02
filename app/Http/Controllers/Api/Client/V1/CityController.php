<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Models\Permanent\Cities;

class CityController extends Controller
{
    public function cities()
    {
        $cities = Cities::getList();

        $collection = collect();
        foreach ($cities as $city) $collection->push($city);
        return $collection->toArray();
    }
}
