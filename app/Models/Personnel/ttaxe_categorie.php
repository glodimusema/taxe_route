<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttaxe_categorie extends Model
{
    protected $fillable=['id','designation','prix_categorie','prix_categorie2'];
    protected $table = 'ttaxe_categorie';
}

// ttaxe_encondeur
// designation
// prix_categorie
