<?php

namespace App\Models\Permanent;

use App\Models\BaseModels\BasePermanentModel;

class TypeAccount extends BasePermanentModel
{
    protected $attributes = [
      1 => 'Особистий',
      2 => 'Бонусний',
      3 => 'Кешбек',
    ];
}
