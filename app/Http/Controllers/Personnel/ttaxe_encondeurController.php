<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{ttaxe_encondeur};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class ttaxe_encondeurController extends Controller
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
            $data = DB::table('ttaxe_encondeur')
            ->select("ttaxe_encondeur.id",'noms','telephone','code_encodeur',
            'password','axe_encodeur',"ttaxe_encondeur.created_at")
            ->where('noms', 'like', '%'.$query.'%')
            ->orWhere('code_encodeur', 'like', '%'.$query.'%')
            ->orderBy("ttaxe_encondeur.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('ttaxe_encondeur')
            ->select("ttaxe_encondeur.id",'noms','telephone','code_encodeur','password','axe_encodeur',
            "ttaxe_encondeur.created_at")
            ->orderBy("ttaxe_encondeur.id", "desc")
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
        //axe_encodeur
        if ($query->id !='') 
        {
            $data = ttaxe_encondeur::where("id", $query->id)->update([
                'noms' =>  $query->noms,
                'telephone' =>  $query->telephone,
                'code_encodeur' =>  $query->code_encodeur,
                'axe_encodeur' =>  $query->axe_encodeur,
                'password' =>  $query->password
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = ttaxe_encondeur::create([
                'noms' =>  $query->noms,
                'telephone' =>  $query->telephone,
                'code_encodeur' =>  $query->code_encodeur,
                'axe_encodeur' =>  $query->axe_encodeur,
                'password' =>  $query->password
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
        }
    }

    function fetch_dropdown_2()
    {
        $data = DB::table('ttaxe_encondeur')
        ->select("ttaxe_encondeur.id",'noms','telephone','code_encodeur','password','axe_encodeur',
        "ttaxe_encondeur.created_at")
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
        $data = ttaxe_encondeur::where('id', $id)->get();
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
        $data = ttaxe_encondeur::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
