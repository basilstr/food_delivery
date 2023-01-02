<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Filter extends Component
{
    public $dataw;
    public $roles;
    public $cities;
    public $providers;
    public $route;

    /**
     * Create a new component instance.
     *
     * @param $title
     * @param $attr
     * @param null $model
     */
    public function __construct($dataw, $cities, $route, $roles=null, $providers=null)
    {
        $this->dataw = $dataw;
        $this->roles = $roles;
        $this->cities = $cities;
        $this->providers = $providers;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.filter');
    }
}
