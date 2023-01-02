<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectBlock extends Select
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-block');
    }
}
