<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_vente;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tvente_detail_venteController extends Controller
{
    use GlobalMethod, Slug;
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    //'id','refEnteteVente','refProduit','puVente','qteVente','author'
    //'id','refClient','dateVente','libelle','author'

    public function all(Request $request)
    { 

        $data = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','puVente','qteVente','dateVente',
        'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tvente_detail_vente.author','tvente_detail_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tvente_detail_vente.devise','tvente_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->selectRaw('((qteVente*puVente)/tvente_detail_vente.taux) as PTVenteFC')
        ->selectRaw('((IFNULL(totalFacture,0))/tvente_detail_vente.taux) as totalFactureFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_vente.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','puVente','qteVente','dateVente',
        'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tvente_detail_vente.author','tvente_detail_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tvente_detail_vente.devise','tvente_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->selectRaw('((qteVente*puVente)/tvente_detail_vente.taux) as PTVenteFC')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','puVente','qteVente','dateVente',
        'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tvente_detail_vente.author','tvente_detail_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tvente_detail_vente.devise','tvente_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->selectRaw('((qteVente*puVente)/tvente_detail_vente.taux) as PTVenteFC')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->where('tvente_detail_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('tvente_detail_vente.id','tvente_detail_vente.refEnteteVente','refProduit','puVente','qteVente','dateVente',
        'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tvente_detail_vente.author','tvente_detail_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tvente_detail_vente.devise','tvente_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->selectRaw('((qteVente*puVente)*tvente_detail_vente.taux) as PTVenteFC')
        ->selectRaw('((IFNULL(montant,0))*tvente_detail_vente.taux) as totalFactureFC')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->Where('tvente_detail_vente.refEnteteVente',$id)               
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {

        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }
// 
        $qte=$request->qteVente;
        $idDetail=$request->refProduit;
        $idFacture=$request->refEnteteVente;
       
        $data = tvente_detail_vente::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $request->refProduit,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteVente'    =>  $request->qteVente,
            'author'       =>  $request->author
        ]);

        $data2 = DB::update(
            'update tvente_produit set qte = qte - :qteVente where id = :refProduit',
            ['qteVente' => $qte,'refProduit' => $idDetail]
        );

        $data3 = DB::update(
            'update tvente_entete_vente set montant = montant + (:pu * :qte) where id = :refEnteteVente',
            ['pu' => $montants,'qte' => $qte,'refEnteteVente' => $idFacture]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {

        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }



        $idFacture=0;
        $montant_last=0;
        $prixunitaire=$montants;
        $qteVente=$request->qteVente;

        $deleteds = DB::table('tvente_detail_vente')
        ->selectRaw('(qteVente*puVente) as prixTotal')
        ->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteVente;
            $montant_last = $deleted->prixTotal;
        }

        $data3 = DB::update(
            'update tvente_entete_vente set montant = montant - (:montant_last) + (:prixunitaire * :qteVente) where id = :refEnteteVente',
            ['montant_last' => $montant_last,'prixunitaire' => $prixunitaire,'qteVente' => $qteVente,'refEnteteVente' => $idFacture]
        );


        $data = tvente_detail_vente::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $request->refProduit,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteVente'    =>  $request->qteVente,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $qte=0;
        $idDetail=0;
        $idFacture=0;
        $montants=0;

        $deleteds = DB::table('tvente_detail_vente')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteVente;
            $idDetail = $deleted->refProduit;
            $idFacture = $deleted->refEnteteVente;
            $montants = $deleted->puVente;
        }

        $data2 = DB::update(
            'update tvente_produit set qte = qte + :qteVente where id = :refProduit',
            ['qteVente' => $qte,'refProduit' => $idDetail]
        );

        $data3 = DB::update(
            'update tvente_entete_vente set montant = montant - (:pu * :qte) where id = :refEnteteVente',
            ['pu' => $montants,'qte' => $qte,'refEnteteVente' => $idFacture]
        );

        $data = tvente_detail_vente::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
