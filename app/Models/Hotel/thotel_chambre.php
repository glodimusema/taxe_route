<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thotel_chambre extends Model
{
    protected $fillable=['id','nom_chambre','numero_chambre','refClasse','author'];
    protected $table = 'thotel_chambre';
}
