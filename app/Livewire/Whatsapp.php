<?php

namespace App\Livewire;


use App\Models\Classe;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Jobs\SendMessagesToProfs;
use App\Jobs\SendMessagesToClasses;
use App\Jobs\SendMessagesToParents;
use App\Jobs\SendMessagesToEmployees;

class Whatsapp extends Component
{
    public $Classes = [];
    public $cls ;

    #[Rule('required',as: ' ')] 
    public $msg;


    public $profs;
    public $emps;
    public $parent;

    function mount() 
    {
        $this->Classes = Classe::all('id', 'nom');
    }

    function send() 
    {
        $this->validate();

        if (!($this->cls or $this->emps or $this->profs or $this->parent)) 
        {
            $magfr = 'Veuillez choisir une option';
            $magar = 'الرجاء اختيار خيار';

            $msg = app()->getLocale() == 'fr' ? $magfr : $magar;
            
            $this->addError('msg',  $msg);
            return;
        }

       if ($this->emps) 
       {
            $this->emp();
       }

       if ($this->profs) 
       {
           $this->prof();
       }

       if ($this->parent) 
        {
            $this->parent();
        }
        
        elseif ($this->cls) 
        {
            $this->cls($this->cls);
        }


    }


    function emp() 
    {
        SendMessagesToEmployees::dispatch($this->msg);
    }

    function prof() 
    {
        SendMessagesToProfs::dispatch($this->msg);
    }

    function parent() 
    {
        SendMessagesToParents::dispatch($this->msg);
    }

    function cls($cls) 
    {
        SendMessagesToClasses::dispatch($this->msg,$cls); 
    }


    public function render()
    {
        return view('livewire.whatsapp');
    }
}
