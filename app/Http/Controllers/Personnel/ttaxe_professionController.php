<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{ttaxe_profession};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// 'id','nom_profession','id_Secteur'
//ttaxe_profession

class ttaxe_professionController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {

        $data = DB::table('ttaxe_profession')
        ->join('ttaxe_secteur','ttaxe_secteur.id','=','ttaxe_profession.id_Secteur')
        ->select("ttaxe_profession.id","ttaxe_profession.nom_profession",'id_Secteur',
        "ttaxe_secteur.nom_secteur","ttaxe_profession.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('ttaxe_profession.nom_profession', 'like', '%'.$query.'%')
            ->orderBy("ttaxe_profession.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));

    }


    function fetch_ttaxe_profession_2()
    {
        $data = DB::table('ttaxe_profession')
        ->join('ttaxe_secteur','ttaxe_secteur.id','=','ttaxe_profession.id_Secteur')
        ->select("ttaxe_profession.id","ttaxe_profession.nom_profession",'id_Secteur',
        "ttaxe_secteur.nom_secteur","ttaxe_profession.created_at")
        ->orderBy("nom_profession", "asc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $query
     * @return \Illuminate\Http\Response
     */
    public function store(Request $query)
    {
        //
        if ($query->id !='') 
        {
            //'id','nom_profession','id_Secteur'
            # code...
            // update 
            $data = ttaxe_profession::where("id", $query->id)->update([
                'nom_profession' =>  $query->nom_profession,
                'id_Secteur' =>  $query->id_Secteur
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = ttaxe_profession::create([
                'nom_profession' =>  $query->nom_profession,
                'id_Secteur' =>  $query->id_Secteur
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
        $data = ttaxe_profession::where('id', $id)->get();
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
        $data = ttaxe_profession::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
