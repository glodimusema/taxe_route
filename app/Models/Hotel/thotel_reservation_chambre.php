<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thotel_reservation_chambre extends Model
{
    protected $fillable=['id','refClient','refChmabre','date_entree','date_sortie','heure_debut','heure_sortie','libelle',
    'prix_unitaire','devise','taux','reduction','observation','type_reservation','nom_accompagner','pays_provenance','paie','author'];
    protected $table = 'thotel_reservation_chambre';
}
