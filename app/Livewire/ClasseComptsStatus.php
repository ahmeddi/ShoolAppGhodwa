<?php

namespace App\Livewire;

use App\Enums\Months;
use Livewire\Component;

class ClasseComptsStatus extends Component
{
    public $Classs;
    public $etuds = [];
    public $etudCount = 0;

    public $payedEtuds;
    public $unpayedEtuds;

    public $payedAmount;
    public $unpayedAmount;

    public $month  = 1;
    public $months = [];


    public function mount()
    {
        $this->months = Months::cases();

        $this->etuds  = $this->Classs->etuds;

        $this->etudCount = $this->etuds->count();

        $payedEtuds = $this->etuds->filter(function ($etud) {
            return $etud->peiements->where('month', $this->month)->count() > 0;
        });

        $this->payedEtuds =  $payedEtuds->count();

        $unpayedEtuds = $this->Classs->etuds->filter(function ($etud) {
            return $etud->peiements->where('month', $this->month)->count() == 0;
        });

        $this->unpayedEtuds = $unpayedEtuds->count();

        $this->payedAmount = $payedEtuds->sum(function ($etud) {
            return $etud->peiements->where('month', $this->month)->sum('montant');
        });

        $unpayedAmount = $this->etuds->sum(function ($etud) {
            return $etud->frais->where('mois', $this->month)->sum('montant');
        });


        $this->unpayedAmount =  $unpayedAmount;
    }

    function monthly()
    {
        // dd($this->month);

        $this->etuds  = $this->Classs->etuds;

        $this->etudCount = $this->etuds->count();

        $payedEtuds = $this->etuds->filter(function ($etud) {
            return $etud->peiements->where('month', $this->month)->count() > 0;
        });

        $this->payedEtuds =  $payedEtuds->count();

        $unpayedEtuds = $this->Classs->etuds->filter(function ($etud) {
            return $etud->peiements->where('month', $this->month)->count() == 0;
        });

        $this->unpayedEtuds = $unpayedEtuds->count();

        $this->payedAmount = $payedEtuds->sum(function ($etud) {
            return $etud->peiements->where('month', $this->month)->sum('montant');
        });


        $unpayedAmount = $this->etuds->sum(function ($etud) {
            return $etud->frais->where('mois', $this->month)->sum('montant');
        });

        $this->unpayedAmount =  $unpayedAmount;
    }

    public function render()
    {
        return view('livewire.classe-compts-status');
    }
}
