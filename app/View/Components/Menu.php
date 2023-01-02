<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Menu extends Component
{
    public $menu;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menu = collect(config('menu'))->map(function ($item) {
           if(isset($item['permission']) && !in_array(Auth::user()->role, $item['permission'])) {
               return null;
           }
            $item['title'] = __($item['title']);
            $item['active'] = request()->routeIs($item['route'] ?? '');
            if(isset($item['items'])) {
                $item['items'] = collect($item['items'])->map(function ($subItem) {
                    if(isset($subItem['permission']) && !in_array(Auth::user()->role, $subItem['permission'])) {
                        return null;
                    }
                    $subItem['title'] = __($subItem['title']);
                    $subItem['active'] = request()->routeIs($subItem['route']);
                    return $subItem;
                });
            }
            return $item;
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu');
    }
}
