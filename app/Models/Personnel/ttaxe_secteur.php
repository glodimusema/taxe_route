<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttaxe_secteur extends Model
{
    protected $fillable=['id','nom_secteur'];
    protected $table = 'ttaxe_secteur';
}
