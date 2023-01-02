<?php

namespace App\Models\Permanent;

use App\Models\BaseModels\BasePermanentModel;

class TypeDrive extends BasePermanentModel
{
    protected $attributes = [
      1 => 'Пішки',
      2 => 'Велосипед',
      3 => 'Автомобіль',
    ];
}
