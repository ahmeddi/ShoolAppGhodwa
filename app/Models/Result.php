<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'mat_id',
        'class_id',
        'examen_id',
        'note',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function mat()
    {
        return $this->belongsTo(Mat::class);
    }

    public function class()
    {
        return $this->belongsTo(Classe::class);
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    public function proportions()
    {

        return  $this->belongsTo(Proportion::class, 'mat_id', 'mat_id')
            ->where('classe_id', $this->class_id);
    }
}
