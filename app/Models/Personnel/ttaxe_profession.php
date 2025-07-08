<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttaxe_profession extends Model
{
    protected $fillable=['id','nom_profession','id_Secteur'];
    protected $table = 'ttaxe_profession';
}

