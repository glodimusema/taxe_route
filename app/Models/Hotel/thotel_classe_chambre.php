<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thotel_classe_chambre extends Model
{
    protected $fillable=['id','designation','prix_chambre','devise','taux','author'];
    protected $table = 'thotel_classe_chambre';
}
