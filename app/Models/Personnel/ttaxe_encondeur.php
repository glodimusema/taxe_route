<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttaxe_encondeur extends Model
{
    protected $fillable=['id','noms','telephone','code_encodeur','password','axe_encodeur'];
    protected $table = 'ttaxe_encondeur'; 
}

