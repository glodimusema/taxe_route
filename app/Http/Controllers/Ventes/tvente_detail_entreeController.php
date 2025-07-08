<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_entree;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tvente_detail_entreeController extends Controller
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
    //'id','refEnteteEntree','refProduit','puEntree','qteEntree','author'

    public function all(Request $request)
    { 

        $data = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','puEntree',
        'qteEntree','noms','contact','mail','adresse','dateEntree',
        'libelle',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_entree.author',
        'tvente_detail_entree.created_at','tvente_detail_entree.devise','tvente_detail_entree.taux')
        ->selectRaw('(qteEntree*puEntree) as PTEntree')
        ->selectRaw('((qteEntree*puEntree)/tvente_detail_entree.taux) as PTEntreeFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_entree.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','puEntree',
        'qteEntree','noms','contact','mail','adresse','dateEntree',
        'libelle',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_entree.author',
        'tvente_detail_entree.created_at','tvente_detail_entree.devise','tvente_detail_entree.taux')
        ->selectRaw('(qteEntree*puEntree) as PTEntree')
        ->selectRaw('((qteEntree*puEntree)/tvente_detail_entree.taux) as PTEntreeFC')
        ->Where('refEnteteEntree',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_entree.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    //mes scripts
      

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','puEntree',
        'qteEntree','noms','contact','mail','adresse','dateEntree',
        'libelle',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_entree.author',
        'tvente_detail_entree.created_at','tvente_detail_entree.devise','tvente_detail_entree.taux')
        ->selectRaw('(qteEntree*puEntree) as PTEntree')
        ->selectRaw('((qteEntree*puEntree)/tvente_detail_entree.taux) as PTEntreeFC')
        ->where('tvente_detail_entree.id', $id)
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
            $montants = ($request->puEntree)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puEntree;
            $devises = $request->devise;
        }



        $qte=$request->qteEntree;
        $idDetail=$request->refProduit;       
        
        $data = tvente_detail_entree::create([
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refProduit'    =>  $request->refProduit,
            'puEntree'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteEntree'    =>  $request->qteEntree,
            'author'       =>  $request->author
        ]);

        $data2 = DB::update(
            'update tvente_produit set qte = qte + :qteEntree where id = :refProduit',
            ['qteEntree' => $qte,'refProduit' => $idDetail]
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
            $montants = ($request->puEntree)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puEntree;
            $devises = $request->devise;
        }



        $data = tvente_detail_entree::where('id', $id)->update([
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refProduit'    =>  $request->refProduit,
            'puEntree'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteEntree'    =>  $request->qteEntree,
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
        $deleteds = DB::select('select * from tvente_detail_entree'); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteEntree;
            $idDetail = $deleted->refProduit;
        }
        $data = tvente_detail_entree::where('id',$id)->delete();

        $data2 = DB::update(
            'update tvente_produit set qte = qte - :qteEntree where id = :refProduit',
            ['qteEntree' => $qte,'refProduit' => $idDetail]
        );
               
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }


}
