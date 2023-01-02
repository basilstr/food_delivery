<?php

namespace App\View\Components;

use App\Models\Permanent\Week;
use Illuminate\View\Component;

class ScheduleShow extends Component
{

    public $model;
    public $attr;
    public $week;

    /**
     * Create a new component instance.
     *

     * @param $attr
     * @param null $model
     * @param bool $multiple
     */
    public function __construct($attr, $model)
    {

        $this->model = $model;
        $this->attr = $attr;
        $week = Week::getList('full');
        for ($i=1; $i<8; $i++) $this->week[$i] = $week[$i];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.schedule-show');
    }
}
