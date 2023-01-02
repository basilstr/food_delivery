<?php

namespace App\Models\Permanent;

use App\Models\BaseModels\BasePermanentModel;

class TypePay extends BasePermanentModel
{
    protected $attributes = [
      1 => 'Готівка',
      2 => 'Картка',
    ];

}
