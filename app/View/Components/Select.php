<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $title;
    public $model;
    public $attr;
    public $items;
    public $multiple;
    public $nullable;
    public $required;
    public $id;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @param $title
     * @param $attr
     * @param $items
     * @param null $model
     * @param bool $multiple
     */
    public function __construct($title, $attr, $items, $model = null, $multiple = false, $nullable = false, $required = false, $id = false, $disabled = false)
    {
        $this->title = $title;
        $this->model = $model;
        $this->attr = $attr;
        $this->items = $items;
        $this->multiple = $multiple;
        $this->nullable = $nullable;
        $this->required = $required;
        $this->id = $id;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select');
    }
}
