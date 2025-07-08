<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{ttaxe_secteur};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// ttaxe_secteur
// nom_secteur

class ttaxe_secteurController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {

        $data = DB::table('ttaxe_secteur')
        ->select("ttaxe_secteur.id","ttaxe_secteur.nom_secteur","ttaxe_secteur.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('ttaxe_secteur.nom_secteur', 'like', '%'.$query.'%')
            ->orderBy("ttaxe_secteur.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));

    }


    function fetch_ttaxe_secteur_2()
    {
        $data = DB::table('ttaxe_secteur')
        ->select("ttaxe_secteur.id","ttaxe_secteur.nom_secteur","ttaxe_secteur.created_at")
        ->orderBy("nom_secteur", "asc")
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
            # code...
            // update 
            $data = ttaxe_secteur::where("id", $query->id)->update([
                'nom_secteur' =>  $query->nom_secteur
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = ttaxe_secteur::create([

                'nom_secteur' =>  $query->nom_secteur
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
        $data = ttaxe_secteur::where('id', $id)->get();
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
        $data = ttaxe_secteur::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
