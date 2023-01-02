<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Photo extends Component
{
    public $title;
    public $model;
    public $attr;

    /**
     * Create a new component instance.
     *
     * @param $title
     * @param $attr
     * @param null $model
     */
    public function __construct($title, $attr, $model=null)
    {
        $this->title = $title;
        $this->model = $model;
        $this->attr = $attr;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.photo');
    }
}
