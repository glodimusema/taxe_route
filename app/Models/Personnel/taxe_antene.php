<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxe_antene extends Model
{
    protected $fillable=['id','nom_antene'];
    protected $table = 'taxe_antene'; 
}

