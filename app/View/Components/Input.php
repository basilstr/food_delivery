<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $title;
    public $model;
    public $attr;
    public $required;
    public $id;

    /**
     * Create a new component instance.
     *
     * @param $title
     * @param $attr
     * @param null $model
     */
    public function __construct($title, $attr, $model = null, $required = false, $id = false)
    {
        $this->title = $title;
        $this->model = $model;
        $this->attr = $attr;
        $this->required = $required;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input');
    }
}
