<?php

namespace App\Livewire;

use App\Models\Etudiant;
use Livewire\Component;

class CLasseCompts extends Component
{
    public $Months = [];
    public $Classs;
    public $etuds = [];

    public function mount()
    {
        $this->etuds  = $this->Classs->etuds;
    }


    public function getEtud($id, $month)
    {
        $etud = Etudiant::find($id);
        $frais = $etud->frais->where('mois', $month)->first()->montant ?? 0;
        $paiement = $etud->peiements->where('mois', $month)->first()->montant ?? 0;

        if ($frais) {
            if ($paiement) {
                if ($paiement >= $frais) {
                    $frais = 0;
                    $status = 1;
                } else {
                    // $frais = $frais - $paiement;
                    $status = 2;
                }
            } else {
                $frais = $frais;
                $status = 3;
            }
        }


        return [
            'frais' => $frais,
            'status' => $status,
        ];
    }

    public function render()
    {
        //  $this->etuds = $this->Classs->etuds;

        if (app()->getLocale() == 'ar') {
            $this->Months = [
                9 => 'سبتمبر',
                10 => 'اكتوبر',
                11 => 'نوفمبر',
                12 => 'ديسمبر',
                1 => 'يناير',
                2 => 'فبراير',
                3 => 'مارس',
                4 => 'ابريل',
                5 => 'مايو',
                6 => 'يونيو',
            ];
        } else {
            $this->Months = [
                9 => 'Septembre',
                10 => 'Octobre',
                1 => 'Janvier',
                2 => 'Février',
                3 => 'Mars',
                4 => 'Avril',
                5 => 'Mai',
                6 => 'Juin',
            ];
        }



        return view('livewire.classe-compts');
    }
}
