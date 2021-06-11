<?php

namespace App\Common\View\Components;

use Illuminate\View\Component;

class Name extends Component
{
    public $trans;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->trans = '_ar';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $trans = $this->trans;
//        dd($trans);
        return view('components.forms.name', compact('trans'));
    }

    /**
     * @return string
     *
     */
//    private function setTrans()
//    {
//        if(app()->getLocale() == 'ar')
//            return $this->trans = '_ar';
//        return $this->trans = '';
//    }
}
