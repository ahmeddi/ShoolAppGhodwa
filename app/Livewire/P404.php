<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class P404 extends Component
{
    public $locale;


    public function mount()
    {
        $this->locale = app()->getLocale();
    }


    function back($locale, $url)
    {
        return redirect()->back();
    }


    public function render()
    {
        return view('livewire.p404');
    }
}
