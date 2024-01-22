<?php

namespace App\Livewire;

use App\Models\Mat;
use Livewire\Component;
use Livewire\Attributes\Js;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class MattAdd extends Component
{
    public $visible = false;

    #[Rule('required')]
    public $nom;

    #[Rule('required')]
    public $lang;


    // protected $listeners = ['mattadd' => 'open',];

    #[On('mattadd')]
    public function open()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();

        $this->visible = true;
    }

    public function save()
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->validate();

        Mat::create([
            'nom'   => $this->nom,
            'arabic'  => $this->lang,
        ]);

        $this->dispatch('refresh');

        $this->reset();
        $this->visible = false;
    }

    #[Js]
    public function close()
    {
        return <<<'JS'
            $wire.visible = false;
        JS;
    }

    public function render()
    {
        return view('livewire.matt-add');
    }
}
