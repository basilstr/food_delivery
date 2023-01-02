<?php

namespace App\View\Components;

use App\Models\Permanent\Week;
use Illuminate\View\Component;

class Schedule extends Component
{

    public $model;
    public $attr;
    public $items;
    public $week;
    public $id;

    /**
     * Create a new component instance.
     *

     * @param $attr
     * @param $items
     * @param null $model
     * @param bool $multiple
     */
    public function __construct($attr, $model = null, $id = false)
    {

        $this->model = $model;
        $this->attr = $attr;
        $this->week = Week::getList('short');
        $this->id = $id;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.schedule');
    }
}
