<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class NameFieldByLang extends Component
{
    public $current_lang;
    public $concatenate_trans;
    public $action;
    public $edit;
    public $langFromModelValue;
    /**
     * Create a new component instance.
     *
     * @return void
     * @throws \Throwable
     */
    public function __construct($lang, $action,$edit)
    {
        $this->setCurrentLang($lang);
        $this->setConcatenateTrans();
        $this->action = $action;
        $this->edit = $edit;
        $this->setTranslatableLang();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.name-field-by-lang');
    }

    /**
     * @param $lang
     * @throws \Throwable
     * @return void
     */
    private function setCurrentLang($lang):void
    {
        throw_unless(in_array($lang,config('app.available_locales')), new \Exception('The Language should be in one of the available system languages,'. implode(',',config('app.available_locales')) ." '$lang' given." ));
            $this->current_lang = $lang;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    private function setConcatenateTrans():string
    {
        if($this->current_lang == 'en') // default used lang in the developing system
            return $this->concatenate_trans = '';
        else
            return $this->concatenate_trans = "_" . "$this->current_lang";
    }

    /**
     *
     */
    private function setTranslatableLang()
    {
        if(is_null($this->edit))
            return '';
        if($this->current_lang == 'en') // default used lang in the developing system
            return $this->langFromModelValue = $this->edit->name;
        $edit = $this->edit;
        return $this->langFromModelValue  = $edit->translations->where('key','name')->where('lang', $this->current_lang)->first()->value;
    }
}
