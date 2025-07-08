<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_vente;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_entete_venteController extends Controller
{
    use GlobalMethod, Slug;
    //vEnteteEntree
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    { 

        $data = DB::table('tvente_entete_vente')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->select('tvente_entete_vente.id','refClient','dateVente','libelle','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tvente_entete_vente.author','tvente_entete_vente.created_at')
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_vente.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));

        // $facture = Facture::query()
        // ->with('detail_factures')
        // ->get();

       // $facture->orderBy("created_at", "desc");

        // return $this->apiData($facture);
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_vente')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->select('tvente_entete_vente.id','refClient','dateVente','libelle','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tvente_entete_vente.author','tvente_entete_vente.created_at')
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }   


    function fetch_single_data($id)
    {

        $data = DB::table('tvente_entete_vente')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->select('tvente_entete_vente.id','refClient','dateVente','libelle','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tvente_entete_vente.author','tvente_entete_vente.created_at')
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->where('tvente_entete_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'id','refClient','dateVente','libelle','author'
    function insert_data(Request $request)
    {
       
        $data = tvente_entete_vente::create([
            'refClient'       =>  $request->refClient,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tvente_entete_vente::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_entete_vente::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
