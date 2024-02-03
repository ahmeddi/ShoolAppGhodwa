<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Parentt;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Js;
use Livewire\Attributes\On;
use App\Models\EtudPaiement;
use Livewire\Attributes\Rule;
use App\Models\PaiementParent;
use App\Services\WhatsappApiService;

class ParentPaiementsAdd extends Component
{
    public $visible = false;

    public $ids;

    public $paiements = [];
    public $total = 0;

    public $Months = [];

    public $etud_id;


    public $etuds = [];

    #[Rule('required', as: ' ')]
    public $date;


    //  #[Rule('required|numeric', as: ' ')]
    // public $montant;

    public $note = '';

    public function mount()
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->resetExcept('ids');

        $this->paiements[] = ['etudiant_id' => null, 'month' => null, 'montant' => null,];
    }


    #[On('open')]
    public function open()
    {
        $this->visible = true;
    }

    protected function rules()

    {
        return [

            "paiements.*.etudiant_id" => 'required|not_in:0',
            "paiements.*.month" => 'required|not_in:0',
            "paiements.*.montant" => 'required',

        ];
    }




    public function save()
    {

        $this->resetErrorBag();
        $this->resetValidation();

        $this->validate();

        // dd($this->getErrorBag());



        $this->total = array_reduce($this->paiements, function ($carry, $paiement) {
            // Ensure that 'montant' is set and is a numeric value
            if (isset($paiement['montant']) && is_numeric($paiement['montant'])) {
                $carry += (int)$paiement['montant'];
            }
            return $carry;
        }, 0);


        $paiements  = PaiementParent::create([
            'parent_id' => $this->ids,
            'date' => $this->date,
            'montant' => $this->total,
            'note' => $this->note,
        ]);



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

        $this->date = Carbon::now()->format('Y-m-d');

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



        return view('livewire.parent-paiements-add');
    }
}
