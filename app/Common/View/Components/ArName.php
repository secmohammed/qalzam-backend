<?php

namespace App\Common\View\Components;

use Illuminate\View\Component;

class ArName extends Component
{
//    public
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.ar_name');
    }
}
