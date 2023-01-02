<?php

namespace App\Models\Permanent;

use App\Models\BaseModels\BasePermanentModel;

class Role extends BasePermanentModel
{
    protected $attributes = [
      'admin'           => 'admin', // root
      'master'          => 'Адміністратор', // root - без доступу до службової інформації / логів / дебагів
      'master_provider' => 'Адміністратор закладу',
      'sub_master_provider' => 'Помічник адміністратора закладу ',
    ];
}
