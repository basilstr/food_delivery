<?php

namespace App\Models\Permanent;

use App\Models\BaseModels\BasePermanentModel;

class TypeDelivery extends BasePermanentModel
{
    protected $attributes = [
      1 => 'До дверей',
      2 => 'До під\'їзду',
      3 => 'Самовивіз',
    ];
}
