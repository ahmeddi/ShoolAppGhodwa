<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proportion extends Model
{
    protected $guarded = [];

    use HasFactory;


    public function sem()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id', 'id');
    }

    public function proportions()
    {
        return $this->hasMany(Proportion::class, 'examen_id', 'id');
    }
}
