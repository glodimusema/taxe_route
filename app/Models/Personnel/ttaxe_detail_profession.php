<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttaxe_detail_profession extends Model
{
    protected $fillable=['id','id_personne','id_profession','date_debut','date_fin','author','refUser'];
    protected $table = 'ttaxe_detail_profession';
}
