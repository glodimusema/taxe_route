<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_vente extends Model
{
    protected $fillable=['id','refEnteteVente','refProduit','puVente','devise','taux','qteVente','author'];
    protected $table = 'tvente_detail_vente';
}
