<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxe_site_affect extends Model
{
    protected $fillable=['id','nom_site_affect','id_sous_poste_affect'];
    protected $table = 'taxe_site_affect';   


}

