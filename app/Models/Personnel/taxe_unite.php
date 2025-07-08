<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxe_unite extends Model
{ 
    protected $fillable=['id','nom_unite'];
    protected $table = 'taxe_unite'; 
}

