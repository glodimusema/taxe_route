<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxe_poste_affect extends Model
{
    protected $fillable=['id','nom_poste','id_antene'];
    protected $table = 'taxe_poste_affect'; 
}

