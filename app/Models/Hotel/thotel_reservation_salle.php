<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thotel_reservation_salle extends Model
{
    protected $fillable=['id','refClient','refSalle','date_ceremonie','heure_debut','heure_sortie',
    'date_reservation','prix_unitaire','devise','taux','reduction','observation','paie','author'];
    protected $table = 'thotel_reservation_salle';
}
