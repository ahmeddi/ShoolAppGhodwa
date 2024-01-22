<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\Profil;
use App\Models\Result;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\Classement;
use App\Models\Proportion;

class BulttinElem extends Component
{
    public $etud, $sem, $mats, $number, $classe;
    public $header;

    public $exam;

    public $mat_total = 0;
    public $etud_total = 0;

    public $Ara_result = [];
    public $Fra_result = [];

    public $Ara_total = 0;
    public $Fra_total = 0;

    public $Ara_etud_total = 0;
    public $Fra_etud_total = 0;

    public $count;

    public $moy = 0;

    public $lang_count;

    public $note;







    public function mount()
    {
        $this->initializeData();
        $this->calculateResults();
        $this->calculateTotals();
        $this->calculateNote();

        $this->header = Profil::find(1)->header;

        $this->exam = $this->sem->examens->where('devoir', 1)->first();
    }

    private function initializeData()
    {
        $this->etud = Etudiant::with('classe')->find($this->etud);
        $this->sem = Semestre::find($this->sem);
        $this->classe = $this->etud->classe->id;
        $this->mats = Classe::find($this->etud->classe->id)->mats;

        $this->exam = $this->sem->examens->where('devoir', 1)->first();


        $ar = $this->mats->where('arabic', 1)->count();
        $fr = $this->mats->where('arabic', 2)->count();

        $this->count = $ar > $fr ? $ar - $fr : $fr - $ar;
        $this->lang_count = $ar > $fr ? 'ar' : 'fr';
    }

    private function calculateResults()
    {

        $this->Ara_result = $this->mats->where('arabic', 1)->map(function ($mat) {


            $mat_ = $mat->only('nom', 'id',);

            $exam_note = $this->getExamResult($mat_['id'],  $this->exam->id);

            $tot =  floatval($exam_note);
            $mat_tot = $this->getProportionFoix($mat_['id']);


            $this->Ara_total += $mat_tot;

            $this->Ara_etud_total += $tot;

            return [
                'nom' => $mat_['nom'],
                'exam_note' => $tot,
                'tot' => round(floatval($tot), 1),
                'mat_tot' => $mat_tot,
            ];
        });

        $this->Fra_result = $this->mats->where('arabic', 2)->map(function ($mat) {

            $mat_ = $mat->only('nom', 'id',);

            $exam_note = $this->getExamResult($mat_['id'],  $this->exam->id);

            $tot =  floatval($exam_note);
            $mat_tot = $this->getProportionFoix($mat_['id']);

            $this->Fra_total += $mat_tot;

            $this->Fra_etud_total += $tot;

            return [
                'nom' => $mat_['nom'],
                'exam_note' => $tot,
                'tot' => round(floatval($tot), 1),
                'mat_tot' => $mat_tot,
            ];
        });
    }

    private function getExamResult($matId, $examenId)
    {
        return Result::where('etudiant_id', $this->etud->id)
            ->where('mat_id', $matId)
            ->where('examen_id', $examenId)
            ->value('note');
    }



    private function getProportionFoix($matId)
    {
        $foix = Proportion::where('classe_id', $this->classe)
            ->where('mat_id', $matId)
            ->first();

        return floatval($foix->tot);
    }


    private function calculateTotals()
    {
        $this->number = Classement::where('semestre_id', $this->sem->id)
            ->where('classe_id', $this->classe)
            ->where('etudiant_id', $this->etud->id)
            ->value('moy');
    }

    private function calculateNote()
    {
        $note = $this->Fra_etud_total + $this->Ara_etud_total;

        $note_total = 10;

        $mat_total = $this->Fra_total + $this->Ara_total;

        if ($mat_total == 0) {
            $this->moy = 0;
            return;
        }

        $this->moy = round(($note * $note_total) / $mat_total, 1);

        $note = [
            1 => "عمل ضعيف - Mauvais travail",
            2 => "يحتاج مزيدا من العمل - A besoin de plus de travail",
            3 => "يمكن ان يكون احسن - Ça pourrait être mieux",
            4 => "عمل مقبول - Passable",
            5 => "لوحة شرف - Tableau d'honneur",
            6 => "تشجيع - Encouragements",
            7 => "تهنئة - Félicitation",
        ];

        if ($this->moy < 3) {
            $this->note = $note[1];
        } else if ($this->moy >= 3 && $this->moy < 4) {
            $this->note = $note[2];
        } else if ($this->moy >= 4 && $this->moy < 4.5) {
            $this->note = $note[3];
        } else if ($this->moy >= 4.5 && $this->moy < 5.5) {
            $this->note = $note[4];
        } else if ($this->moy >= 5.5 && $this->moy < 6.5) {
            $this->note = $note[5];
        } else if ($this->moy >= 6.5 && $this->moy < 7.5) {
            $this->note = $note[6];
        } else if ($this->moy > 7.5) {
            $this->note = $note[7];
        }
    }

    public function render()
    {
        $mat_total = $this->Fra_total + $this->Ara_total;


        if ($mat_total != 0) {


            $note = $this->Fra_etud_total + $this->Ara_etud_total;

            $note_total = 10;

            $mat_total = $this->Fra_total + $this->Ara_total;

            $this->moy = round(($note * $note_total) / $mat_total, 1);
        }




        return view('livewire.bulttin-elem');
    }
}
