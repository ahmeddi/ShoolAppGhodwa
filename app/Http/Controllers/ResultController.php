<?php

namespace App\Http\Controllers;

use App\Models\Mat;
use App\Models\Prof;
use App\Models\Classe;
use App\Models\Examen;
use App\Models\Etudiant;
use App\Models\Semestre;
use Illuminate\Http\Request;
use App\Services\CalculBulttin;
use App\Models\ProfClassesResult;
use App\Services\CalculBulttinElemnt;

class ResultController extends Controller
{
    public function show($locale, $classe, $mat, $dev)
    {
        if (auth()->user()->parent_id) {
            abort(403);
        }
        if (auth()->user()->prof_id) {
            $prof = Prof::find(auth()->user()->prof_id);

            $classMat = ProfClassesResult::where('classe_id', $classe)->where('mat_id', $mat)->first();

            $classep = $prof->classes->find($classe);

            $matp = $prof->mats->find($mat);


            if (!$classep || !$matp || !$classMat) {
                abort(403);
            }
        }

        $classe = Classe::with('etuds')->get()->find($classe);

        if ($classe->mats->whereIn('id', [$mat])->count()) {
            $mat    = Mat::find($mat);
            $dev    = Examen::find($dev);

            if (!($dev)) {
                abort(404);
            }
            if (!($dev->sem)) {
                abort(404);
            }

            if (app()->getLocale() == 'ar') {
                $sem_nom = $dev->sem->nom;
                $dev_nom = $dev->nom;
            } else {
                $sem_nom = $dev->sem->nomfr;
                $dev_nom = $dev->nomfr;
            }

            return view('Resultat', [
                'classe' => $classe,
                'mat' => $mat,
                'dev' => $dev,
                'mat_nom' => $mat->nom,
                'sem_nom' => $sem_nom,
                'dev_nom' => $dev_nom,
            ]);
        } else {
            return abort(404);
        }
    }

    public function bulltin($locale, $etud, $sem)
    {
        if (auth()->user()->role == 'prof') {
            abort(403);
        }

        if (auth()->user()->parent_id) {
            abort(403);
        }

        if (Semestre::find($sem)) {

            $etud = Etudiant::find($etud);

            $this->calculBulttin($etud->classe->id, $sem, $etud->classe->moy);

            return view('Bulltin', [
                'etud' => $etud->id,
                'sem' => $sem,
                'classe_moy' => $etud->classe->moy,
            ]);
        } else {
            return abort(404);
        }
    }

    public function result($etud)
    {
        if (auth()->user()->parent_id or auth()->user()->prof_id) {
            abort(403);
        }

        $sems = Semestre::all();


        return view('EtudsSemestres', [
            'sems' => $sems,
            'etud' => $etud,
        ]);
    }

    public function notes($locale, $etud)
    {
        if (auth()->user()->prof_id) {
            abort(403);
        }

        $etudiant = Etudiant::find($etud);

        $etudiant ? $etudiant : abort(404);

        if (auth()->user()->parent_id) {
            if (!(auth()->user()->parent_id == $etudiant->parent_id)) {
                abort(403);
            }
        }

        //  $results = $etudiant->results;

        //  dd($results);


        return view('ResultEtud', [
            // 'results' => $results,
            'etudiant' => $etudiant,
        ]);
    }


    public function calculBulttin($classeId, $semId, $isEelm)
    {
        if ($isEelm) {
            new CalculBulttinElemnt($classeId, $semId);
        } else {
            new CalculBulttin($classeId, $semId);
        }
    }
}
