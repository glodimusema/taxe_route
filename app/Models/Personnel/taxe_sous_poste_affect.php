<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxe_sous_poste_affect extends Model
{
    protected $fillable=['id','nom_sous_poste','id_poste_affect'];
    protected $table = 'taxe_sous_poste_affect'; 
}

