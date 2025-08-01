<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttaxe_paiement extends Model
{
    protected $fillable=['id','montant','montantLettre','motif','dateOperation',
    'refEse','refCompte','refAgent','compteur','compteur2','refMois','refAnnee',
    'author','qte','recouvrement','refExploitation','marque_vehicule','lieu_chargement',
    'destination','bordereau','observations'];
    protected $table = 'ttaxe_paiement';
}

// ttaxe_paiement
// montant
// montantLettre
// motif
// dateOperation
// refEse
// refCompte
// refAgent
// author


