<?php

namespace App\Common\View\Components;

use Illuminate\View\Component;

class SmallImage extends Component
{
//    public
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $image;
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
        return view('components.forms.small_image');
    }
}
