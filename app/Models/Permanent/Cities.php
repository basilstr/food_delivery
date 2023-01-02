<?php

namespace App\Models\Permanent;

use App\Models\BaseModels\BasePermanentModel;

class Cities extends BasePermanentModel
{
    protected $attributes = [
        1 => [
            'id' => 1,
            'name' => 'Хмельницький',
            'lat' => '49.424862',
            'lon' => '26.983493',
            'radius' => 7000,
        ],
        2 => [
            'id' => 2,
            'name' => 'Вінниця',
            'lat' => '49.238091',
            'lon' => '28.484396',
            'radius' => 12000,
        ],
    ];
}
