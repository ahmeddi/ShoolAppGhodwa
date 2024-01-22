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

class Bullltin extends Component
{
    public $etud, $sem, $mats, $results = [], $number, $classe, $tot = 0, $totmat = 0, $moy, $classmoy, $tots, $note;
    public $header;


    public $mat_total = 0;
    public $etud_total = 0;
    public $count_mat_foix = 0;

    public function mount()
    {
        $this->initializeData();

        $this->calculateResults();

        $this->getRank();

        $this->calculateNote();

        $this->header = Profil::find(1)->header;
    }

    private function initializeData()
    {
        $this->etud = Etudiant::with('classe')->find($this->etud);
        $this->sem = Semestre::find($this->sem);
        $this->classe = $this->etud->classe->id;
        $this->classmoy = $this->etud->classe->moy;
        $this->mats = Classe::find($this->etud->classe->id)->mats;
    }

    private function calculateResults()
    {
        if ($this->sem->examens->isNotEmpty()) {
            $this->results = $this->mats->map(function ($mat) {

                $mat_ = $mat->only('nom', 'id');

                $devs_notes = [];
                $devs_moy = 0;
                $devs_count = 0;
                $devs_tot = 0;
                $exam_note = 0;
                $dev_note = 0;

                foreach ($this->sem->examens as $dev) {
                    if ($dev->devoir == 1) {
                        $exam_note = $this->getExamResult($mat_['id'], $dev->id);
                        continue;
                    }

                    $dev_note = $this->getDevResult($mat_['id'], $dev->id);

                    if ($dev_note && $dev_note->note) {
                        $devs_notes[] = $dev_note->note;
                        $devs_count += (float) $dev_note->note;
                        $devs_tot++;
                    }
                }

                $foix = $this->getProportionFoix($mat_['id']);

                $devs_moy = $devs_tot ? $devs_count / $devs_tot : '';
                $exam_note =  floatval($exam_note);

                $tot = round(floatval($foix * $exam_note), 1);


                $this->etud_total +=  $tot;

                $this->count_mat_foix += $foix;

                return [
                    'nom' => $mat_['nom'],
                    'devn' => implode(" - ", $devs_notes),
                    'devm' => $devs_moy,
                    'examn' => $exam_note,
                    'moy' => $exam_note, // devs_moy + exam_note
                    'foix' => $foix,
                    'tot' => $tot,
                ];
            });
        }

        $this->moy = round(floatval($this->etud_total / $this->count_mat_foix), 1);
    }

    private function getExamResult($matId, $examenId)
    {
        return Result::where('etudiant_id', $this->etud->id)
            ->where('mat_id', $matId)
            ->where('examen_id', $examenId)
            ->value('note');
    }

    private function getDevResult($matId, $examenId)
    {
        return Result::where('etudiant_id', $this->etud->id)
            ->where('mat_id', $matId)
            ->where('examen_id', $examenId)
            ->first();
    }

    private function getProportionFoix($matId)
    {
        $foix = Proportion::where('classe_id', $this->classe)
            ->where('mat_id', $matId)
            ->first();

        return !$this->classmoy ? ($foix ? floatval($foix->foix) : 1) : floatval($foix->tot);
    }


    private function getRank()
    {
        $this->number = Classement::where('semestre_id', $this->sem->id)
            ->where('classe_id', $this->classe)
            ->where('etudiant_id', $this->etud->id)
            ->value('moy');
    }

    private function calculateNote()
    {
        $note = [
            1 => "عمل ضعيف - Mauvais travail",
            2 => "يحتاج مزيدا من العمل - A besoin de plus de travail",
            3 => "يمكن ان يكون احسن - Ça pourrait être mieux",
            4 => "عمل مقبول - Passable",
            5 => "لوحة شرف - Tableau d'honneur",
            6 => "تشجيع - Encouragements",
            7 => "تهنئة - Félicitation",
        ];

        if ($this->moy < 6) {
            $this->note = $note[1];
        } else if ($this->moy >= 6 && $this->moy < 8) {
            $this->note = $note[2];
        } else if ($this->moy >= 8 && $this->moy < 9) {
            $this->note = $note[3];
        } else if ($this->moy >= 9 && $this->moy < 11) {
            $this->note = $note[4];
        } else if ($this->moy >= 11 && $this->moy < 13) {
            $this->note = $note[5];
        } else if ($this->moy >= 13 && $this->moy < 15) {
            $this->note = $note[6];
        } else if ($this->moy > 15) {
            $this->note = $note[7];
        }
    }

    public function render()
    {
        return view('livewire.bullltin');
    }
}
