<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Hotel\{thotel_chambre};
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

use App\User;
use App\Message;


class thotel_chambreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //id,nom_chambre,author

        $data = DB::table("thotel_chambre")
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->select("thotel_chambre.id", "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
        "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre",
        "thotel_classe_chambre.devise","thotel_classe_chambre.taux", 
        "thotel_chambre.created_at", "thotel_chambre.author");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('thotel_chambre.nom_chambre', 'like', '%'.$query.'%')
            ->orderBy("thotel_chambre.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_thotel_chambre_2()
    {
         $data = DB::table("thotel_chambre")
         ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
         ->select("thotel_chambre.id", "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
         "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre",
         "thotel_classe_chambre.devise","thotel_classe_chambre.taux", 
         "thotel_chambre.created_at", "thotel_chambre.author")
        ->get();
        
        return response()->json(['data' => $data]);

    }


    function fetch_thotel_chambre_libre(Request $request)
    {
        $dateentree = '';
        $datesortie = '';
        $refClasses = 0;

        if ($request->get('date_entree') && $request->get('date_sortie') && $request->get('refClasse')) {
            // code...
            $dateentree = $request->get('date_entree');
            $datesortie = $request->get('date_sortie');
            $refClasses = $request->get('refClasse');

            $dateentree_new=date('Y-m-d',strtotime($dateentree));
            $datesortie_new=date('Y-m-d',strtotime($datesortie));

            $data = \DB::select(
                "select thotel_chambre.id,thotel_chambre.nom_chambre,numero_chambre,refClasse, 
                thotel_classe_chambre.designation as ClasseChambre,thotel_classe_chambre.prix_chambre,
                thotel_classe_chambre.devise,thotel_classe_chambre.taux from thotel_chambre
                inner join thotel_classe_chambre on thotel_classe_chambre.id = thotel_chambre.refClasse
                where (thotel_chambre.id not in (select refChmabre from thotel_reservation_chambre 
                where (date_entree=$dateentree or date_sortie=$dateentree
                or (($dateentree>=date_entree) and ($dateentree<=date_sortie)) 
                or $datesortie=date_sortie or $datesortie=date_entree 
                or (($datesortie>=date_entree) AND ($datesortie<=date_sortie))))) 
                and (refClasse = $refClasses)"
                // ,
                // ["dateentree"=>$dateentree_new,"datesortie"=>$datesortie_new,"refClasses"=>1]
            );

            
            // $data = DB::select(
            //     'select thotel_chambre.id,thotel_chambre.nom_chambre,numero_chambre,refClasse, 
            //     thotel_classe_chambre.designation as ClasseChambre,thotel_classe_chambre.prix_chambre,
            //     thotel_classe_chambre.devise,thotel_classe_chambre.taux from thotel_chambre
            //     inner join thotel_classe_chambre on thotel_classe_chambre.id = thotel_chambre.refClasse
            //     where (thotel_chambre.id not in (select refChmabre from thotel_reservation_chambre 
            //     where (date_entree=:dateentree or date_sortie=:dateentree
            //     or ((:dateentree>=date_entree) and (:dateentree<=date_sortie)) 
            //     or :datesortie=date_sortie or :datesortie=date_entree 
            //     or ((:datesortie>=date_entree) AND (:datesortie<=date_sortie))))) 
            //     and (refClasse = :refClasse)',
            //      ['dateentree'=>$dateentree,'datesortie'=>$datesortie,'refClasse'=>$refClasse]
            // );
           
           return response()->json(['data' => $data]);
            
        }
        else{
        }

        

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

              //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = thotel_chambre::where("id", $request->id)->update([
                'nom_chambre' =>  $request->nom_chambre,
                'numero_chambre' =>  $request->numero_chambre,
                'refClasse' =>  $request->refClasse,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = thotel_chambre::create([
                'nom_chambre' =>  $request->nom_chambre,
                'numero_chambre' =>  $request->numero_chambre,
                'refClasse' =>  $request->refClasse,
                'author' =>  $request->author
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = DB::table("thotel_chambre")
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->select("thotel_chambre.id", "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
        "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre",
        "thotel_classe_chambre.devise","thotel_classe_chambre.taux", 
        "thotel_chambre.created_at", "thotel_chambre.author")
        ->where('thotel_chambre.id', $id)
        ->get();
        return response()->json(['data' => $data]);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = thotel_chambre::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
