<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Models\PaiementParent;
use Illuminate\Support\Facades\DB;
use App\Services\WhatsappApiService;
use App\Enums\Dates;

use App\Traits\Rangables;



class ParentPaiements extends Component
{

  public $ids;
  use Rangables;



  public function mount()
  {


    $this->ranges = Dates::cases();

    $this->rangeName = Dates::All_Time->label();


    $casesToKeep = ['month', 'today', 'past_month', 'all', 'custom'];

    $this->ranges = array_filter($this->ranges, function ($case) use ($casesToKeep) {
      return in_array($case->value, $casesToKeep);
    });
  }










  #[On('delete')]
  function delete($idkey)
  {
    PaiementParent::find($idkey)->delete();
    $this->mount();
  }

  #[On('wh')]
  function wh($id)
  {
    $paiement = PaiementParent::find($id);
    $recet = new WhatsappApiService();
    $num = $paiement->parent->whatsapp;
    $nom = $paiement->parent->nom;
    $nomfr = $paiement->parent->nomfr;
    $sex = $paiement->parent->sexe;
    $code = $paiement->parent->whcode;
    $date = $paiement->date;
    $id = $paiement->parent->id;
    //   $num = '36411579';
    $montant = $paiement->montant;
    $msg = $recet->recets($id, $num, $code, $nom, $nomfr, $sex, $date, $montant);

    $paiement->wh = $msg;
    $paiement->save();
    $this->mount();
  }



  #[On('refresh')]
  public function render()
  {

    $this->table_col_id =  'parent_id';
    $this->table_col_date = 'date';

    $paiements = PaiementParent::where('parent_id', $this->ids);

    $paiements = $this->updatedSelectedRange($paiements);

    $paiements = $this->applySorting($paiements);

    $paiements =  $paiements->get();



    return view(
      'livewire.parent-paiements',
      ['paiements' => $paiements]
    );
  }
}
