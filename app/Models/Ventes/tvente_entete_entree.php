<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_entree extends Model
{
    protected $fillable=['id','refFournisseur','dateEntree','libelle','author'];
    protected $table = 'tvente_entete_entree';
}
