<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{ttaxe_axe};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class ttaxe_axeController extends Controller
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
            $data = DB::table('ttaxe_axe')
            ->select("ttaxe_axe.id",'nom_axe',"ttaxe_axe.created_at")
            ->where('nom_axe', 'like', '%'.$query.'%')
            ->orderBy("ttaxe_axe.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('ttaxe_axe')
            ->select("ttaxe_axe.id",'nom_axe',"ttaxe_axe.created_at")
            ->orderBy("ttaxe_axe.id", "desc")
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
        //prix_categorie2
        if ($query->id !='') 
        {
 
            $data = ttaxe_axe::where("id", $query->id)->update([
                'nom_axe' =>  $query->nom_axe
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = ttaxe_axe::create([
                'nom_axe' =>$query->nom_axe
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
        }
    }

    function fetch_dropdown_2()
    {
        $data = DB::table('ttaxe_axe')
        ->select("ttaxe_axe.id",'nom_axe',"ttaxe_axe.created_at")
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
        $data = ttaxe_axe::where('id', $id)->get();
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
        $data = ttaxe_axe::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
