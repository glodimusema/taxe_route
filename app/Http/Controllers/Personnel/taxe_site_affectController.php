<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{taxe_site_affect};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class taxe_site_affectController extends Controller
{
    use GlobalMethod;
    use Slug;

    function Gquery($query)
    {
      return str_replace(" ", "%", $query->get('query'));
      // return $query->get('query');
    }

    public function index(Request $query)
    {
        //
        
        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);
            $data = DB::table('taxe_site_affect')
            ->join('taxe_sous_poste_affect' , 'taxe_sous_poste_affect.id','=','taxe_site_affect.id_sous_poste_affect')
            ->join('taxe_poste_affect' , 'taxe_poste_affect.id','=','taxe_sous_poste_affect.id_poste_affect')
            ->join('taxe_antene' , 'taxe_antene.id','=','taxe_poste_affect.id_antene') 
            ->select("taxe_site_affect.id",'nom_site_affect','id_sous_poste_affect',
            'nom_sous_poste','id_poste_affect','nom_poste','id_antene','nom_antene',
            "taxe_site_affect.created_at")
            ->where('nom_site_affect', 'like', '%'.$query.'%')
            ->orderBy("taxe_site_affect.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('taxe_site_affect')
            ->join('taxe_sous_poste_affect' , 'taxe_sous_poste_affect.id','=','taxe_site_affect.id_sous_poste_affect')
            ->join('taxe_poste_affect' , 'taxe_poste_affect.id','=','taxe_sous_poste_affect.id_poste_affect')
            ->join('taxe_antene' , 'taxe_antene.id','=','taxe_poste_affect.id_antene') 
            ->select("taxe_site_affect.id",'nom_site_affect','id_sous_poste_affect',
            'nom_sous_poste','id_poste_affect','nom_poste','id_antene','nom_antene',
            "taxe_site_affect.created_at")
            ->orderBy("taxe_sous_poste_affect.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $query
     * @return \Illuminate\Http\Response
     */
    public function store(Request $query)
    {
        //id_antene
        if ($query->id !='') 
        {
 
            $data = taxe_site_affect::where("id", $query->id)->update([
                'nom_site_affect' =>  $query->nom_site_affect,
                'id_sous_poste_affect' =>  $query->id_sous_poste_affect
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = taxe_site_affect::create([
                'nom_site_affect' =>  $query->nom_site_affect,
                'id_sous_poste_affect' =>  $query->id_sous_poste_affect
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
        }
    }

    function fetch_dropdown_2()
    {
        $data = DB::table('taxe_site_affect')
        ->join('taxe_sous_poste_affect' , 'taxe_sous_poste_affect.id','=','taxe_site_affect.id_sous_poste_affect')
        ->join('taxe_poste_affect' , 'taxe_poste_affect.id','=','taxe_sous_poste_affect.id_poste_affect')
        ->join('taxe_antene' , 'taxe_antene.id','=','taxe_poste_affect.id_antene') 
        ->select("taxe_site_affect.id",'nom_site_affect','id_sous_poste_affect',
        'nom_sous_poste','id_poste_affect','nom_poste','id_antene','nom_antene',
        "taxe_site_affect.created_at")
        ->orderBy("taxe_site_affect.id", "desc")
        ->orderBy("id", "desc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

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
        $data = DB::table('taxe_site_affect')
        ->join('taxe_sous_poste_affect' , 'taxe_sous_poste_affect.id','=','taxe_site_affect.id_sous_poste_affect')
        ->join('taxe_poste_affect' , 'taxe_poste_affect.id','=','taxe_sous_poste_affect.id_poste_affect')
        ->join('taxe_antene' , 'taxe_antene.id','=','taxe_poste_affect.id_antene') 
        ->select("taxe_site_affect.id",'nom_site_affect','id_sous_poste_affect',
        'nom_sous_poste','id_poste_affect','nom_poste','id_antene','nom_antene',
        "taxe_site_affect.created_at")
        ->orderBy("taxe_site_affect.id", "desc")
        ->where('taxe_site_affect.id', $id)
        ->get();
        return response()->json(['data' => $data]);
    }


    function fetch_data_entete($id_data)
    {

        $data = DB::table('taxe_site_affect')
        ->join('taxe_sous_poste_affect' , 'taxe_sous_poste_affect.id','=','taxe_site_affect.id_sous_poste_affect')
        ->join('taxe_poste_affect' , 'taxe_poste_affect.id','=','taxe_sous_poste_affect.id_poste_affect')
        ->join('taxe_antene' , 'taxe_antene.id','=','taxe_poste_affect.id_antene') 
        ->select("taxe_site_affect.id",'nom_site_affect','id_sous_poste_affect',
        'nom_sous_poste','id_poste_affect','nom_poste','id_antene','nom_antene',
        "taxe_site_affect.created_at")
        ->where('taxe_site_affect.id_sous_poste_affect', $id_data)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
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
        $data = taxe_sous_poste_affect::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
