<?php

namespace App\Models\Permanent;

use App\Models\BaseModels\BasePermanentModel;

class Week extends BasePermanentModel
{
    // такий порядок вибраний для виводу редагування днів в дві колонки
    protected $attributes = [
        1 => [
            'full' => 'Понеділок',
            'short' => 'Пн',
        ],
        4 => [
            'full' => 'Четвер',
            'short' => 'Чт',
        ],
        2 => [
            'full' => 'Вівторок',
            'short' => 'Вт',
        ],
        5 => [
            'full' => 'П\'ятниця',
            'short' => 'Пн',
        ],
        3 => [
            'full' => 'Середа',
            'short' => 'Ср',
        ],
        6 => [
            'full' => 'Субота',
            'short' => 'Сб',
        ],
        0 => [ // пустий елемент
            'full' => '',
            'short' => '',
        ],
        7 => [
            'full' => 'Неділя',
            'short' => 'Нд',
        ],
    ];
}
