<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtudPaiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'paiement_parent_id',
        'etudiant_id',
        'montant',
        'month',
    ];


    public function etud()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }
}
