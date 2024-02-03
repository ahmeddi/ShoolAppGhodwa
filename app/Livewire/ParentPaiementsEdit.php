<?php

namespace App\Livewire;

use App\Models\Parentt;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Js;
use Livewire\Attributes\On;
use App\Models\EtudPaiement;
use Livewire\Attributes\Rule;
use App\Models\PaiementParent;

class ParentPaiementsEdit extends Component
{

    public $visible = false;

    public $paiements = [];
    public $total = 0;

    public $Months = [];

    public $etud_id;


    public $etuds = [];

    public $ids;

    public $pids;



    #[Rule('required', as: ' ')]
    public $date;

    public $note;





    // #[Rule('required|numeric', as:' ')] 
    //   public $montant;

    protected function rules()

    {
        return [

            "paiements.*.etudiant_id" => 'required|not_in:0',
            "paiements.*.month" => 'required|not_in:0',
            "paiements.*.montant" => 'required',

        ];
    }

    #[On('edit')]
    public function open($id)
    {

        $this->resetErrorBag();
        $this->resetValidation();

        $paiement = PaiementParent::find($id);

        $this->pids = $paiement->id;
        //  $this->montant = $paiement->montant;
        $this->date = $paiement->date;
        $this->note = $paiement->note;


        $this->paiements = $paiement->etudPaiements;

        $this->total = collect($this->paiements)->sum('montant');

        $this->paiements = collect($this->paiements->toArray())->map(function ($item, $key) {
            return [
                'id' => $key,
                'etudiant_id' => $item['etudiant_id'],
                'month' => $item['month'],
                'montant' => $item['montant'],
            ];
        })->toArray();

        //  dd($this->paiements);




        $this->visible = true;
    }


    public function save()
    {


        $this->resetErrorBag();
        $this->resetValidation();

        $this->validate();


        $paiements = PaiementParent::find($this->pids);

        $this->total = array_reduce($this->paiements, function ($carry, $paiement) {
            // Ensure that 'montant' is set and is a numeric value
            if (isset($paiement['montant']) && is_numeric($paiement['montant'])) {
                $carry += (int)$paiement['montant'];
            }
            return $carry;
        }, 0);

        $paiements->update([
            'date' => $this->date,
            'montant' => $this->total,
            'parent_id' => $this->ids,
            'note' => $this->note,
        ]);

        // dd($paiements);
        /*
        $etudspeiments = EtudPaiement::where('paiement_parent_id', $paiements->id)->get();

        foreach ($etudspeiments as $etudpaiement) {
            $etudpaiement->delete();
        }

        foreach ($this->paiements as $paiement) {
            EtudPaiement::create([
                'etudiant_id' => $paiement['etudiant_id'],
                'month' => $paiement['month'],
                'montant' => $paiement['montant'],
                'paiement_parent_id' => $paiements->id,
            ]);
        }
*/
        $etudspeiments = EtudPaiement::where('paiement_parent_id', $paiements->id)->get();

        foreach ($etudspeiments as $etudpaiement) {
            $etudpaiement->delete();
        }

        // Create new EtudPaiement records
        $paiements->etudPaiements()->createMany($this->paiements);


        $this->visible = false;

        $this->dispatch('refresh');
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
        $this->etuds = Parentt::find($this->ids)->etuds;

        // dd($this->etuds);


        if (app()->getLocale() == 'ar') {
            $this->Months = [
                1 => 'يناير',
                2 => 'فبراير',
                3 => 'مارس',
                4 => 'ابريل',
                5 => 'مايو',
                6 => 'يونيو',
                7 => 'يوليو',
                8 => 'اغسطس',
                9 => 'سبتمبر',
                10 => 'اكتوبر',
                11 => 'نوفمبر',
                12 => 'ديسمبر',
            ];
        } else {
            $this->Months = [
                1 => 'Janvier',
                2 => 'Février',
                3 => 'Mars',
                4 => 'Avril',
                5 => 'Mai',
                6 => 'Juin',
                7 => 'Juillet',
                8 => 'Août',
                9 => 'Septembre',
                10 => 'Octobre',
                11 => 'Novembre',
                12 => 'Décembre',
            ];
        }

        $this->Months = collect($this->Months)->map(function ($item, $key) {
            return ['id' => $key, 'nom' => $item];
        })->toArray();



        return view('livewire.parent-paiements-edit');
    }
}
