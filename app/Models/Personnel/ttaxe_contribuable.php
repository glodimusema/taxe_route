<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttaxe_contribuable extends Model
{
    protected $fillable=['id','colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese',
        'colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese',
        'colAdresseEntreprise_Ese','colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus',
        'photo','slug','author','entreprisePhone1','entreprisePhone2','entrepriseMail','Details','axes_encodeur','solde'];
    protected $table = 'ttaxe_contribuable';
}


