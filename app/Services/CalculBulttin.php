<?php

namespace App\Services;

use App\Models\Classe;
use App\Models\Result;
use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\Classement;
use App\Models\Proportion;


class CalculBulttin
{
    protected $classeId;
    protected $semId;
    protected $tot = 0, $totmat = 0, $moy, $classmoy, $sem, $classe;

    protected $mat_total = 0;
    protected $etud_total = 0;
    protected $count_mat_foix = 0;

    protected $mats;


    public function __construct(int $classeId, int $semId)
    {
        $this->classeId = $classeId;
        $this->semId = $semId;

        $this->classe = Classe::find($this->classeId);

        $this->classmoy = $this->classe->moy;

        $this->sem = Semestre::find($this->semId);

        $etudiants = $this->classe->etuds;

        $this->mats =  $this->classe->mats;

        foreach ($etudiants as $etudiant) {
            $this->calculateStudentResults($etudiant);
        }

        $this->calculateRanks();
    }


    private function calculateStudentResults(Etudiant $etudiant)
    {
        $mats = Classe::find($this->classeId)->mats;

        $etud_total =  0;
        $count_mat_foix = 0;

        foreach ($this->mats as  $mat) {

            $mat_ = $mat->only('nom', 'id');

            $devs_notes = [];
            $devs_moy = 0;
            $devs_count = 0;
            $devs_tot = 0;
            $exam_note = 0;
            $dev_note = 0;


            foreach ($this->sem->examens as $dev) {
                if ($dev->devoir == 1) {
                    $exam_note = $this->getExamResult($etudiant->id, $mat_['id'], $dev->id,);
                    continue;
                }

                $dev_note = $this->getDevResult($mat_['id'], $dev->id, $etudiant->id);

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

            $etud_total +=  $tot;

            $count_mat_foix += $foix;
        };

        $this->addNote($etud_total, $etudiant->id);
    }


    private function getExamResult(int $etudiantId, int $matId, int $examenId)
    {
        return Result::where('etudiant_id', $etudiantId)
            ->where('mat_id', $matId)
            ->where('examen_id', $examenId)
            ->value('note');
    }


    private function getDevResult(int $etudiantId, int $matId, int $examenId)
    {
        return Result::where('etudiant_id', $etudiantId)
            ->where('mat_id', $matId)
            ->where('examen_id', $examenId)
            ->first();
    }


    private function getProportionFoix(int $matId)
    {
        $foix = Proportion::where('classe_id', $this->classeId)
            ->where('mat_id', $matId)
            ->first();

        return $foix ? floatval($foix->foix) : 1;
    }



    private function addNote($tots, $etudiantId)
    {
        $classement = Classement::firstOrCreate([
            'etudiant_id' => $etudiantId,
            'semestre_id' => $this->semId,
            'classe_id' => $this->classeId,
        ]);

        $classement->note = $tots;
        $classement->save();
    }

    private function calculateRanks()
    {
        $competitors = Classement::where('semestre_id', $this->semId)
            ->where('classe_id', $this->classeId)
            ->orderBy('note', 'desc')
            ->get();

        foreach ($competitors as $key => $competitor) {
            $competitor->moy = $key + 1;
            $competitor->save();
        }
    }
}
