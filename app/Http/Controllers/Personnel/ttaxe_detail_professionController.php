<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\ttaxe_detail_profession;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;


class ttaxe_detail_professionController extends Controller
{
    use GlobalMethod, Slug  ;

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
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('ttaxe_detail_profession')
            ->join('ttaxe_profession','ttaxe_profession.id','=','ttaxe_detail_profession.id_profession')
            ->join('ttaxe_secteur','ttaxe_secteur.id','=','ttaxe_profession.id_Secteur')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_detail_profession.id_personne')
            ->select("ttaxe_detail_profession.id",'id_personne','id_profession','date_debut','date_fin',
            'ttaxe_detail_profession.author','ttaxe_detail_profession.refUser',
            "ttaxe_profession.nom_profession",'id_Secteur',"ttaxe_secteur.nom_secteur"
            ,'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus')
            ->selectRaw("DATE_FORMAT(ttaxe_detail_profession.created_at,'%d/%M/%Y') as dateOperation")
            ->where([
                ['colNom_Ese', 'like', '%'.$query.'%']
            ])               
            ->orderBy("ttaxe_detail_profession.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('ttaxe_detail_profession')
            ->join('ttaxe_profession','ttaxe_profession.id','=','ttaxe_detail_profession.id_profession')
            ->join('ttaxe_secteur','ttaxe_secteur.id','=','ttaxe_profession.id_Secteur')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_detail_profession.id_personne')
            ->select("ttaxe_detail_profession.id",'id_personne','id_profession','date_debut','date_fin',
            'ttaxe_detail_profession.author','ttaxe_detail_profession.refUser',
            "ttaxe_profession.nom_profession",'id_Secteur',"ttaxe_secteur.nom_secteur"
            ,'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus')
            ->selectRaw("DATE_FORMAT(ttaxe_detail_profession.created_at,'%d/%M/%Y') as dateOperation")
            ->orderBy("ttaxe_detail_profession.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }

    public function fetch_detail_entete(Request $request,$refEntete)
    {

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('ttaxe_detail_profession')
            ->join('ttaxe_profession','ttaxe_profession.id','=','ttaxe_detail_profession.id_profession')
            ->join('ttaxe_secteur','ttaxe_secteur.id','=','ttaxe_profession.id_Secteur')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_detail_profession.id_personne')
            ->select("ttaxe_detail_profession.id",'id_personne','id_profession','date_debut','date_fin',
            'ttaxe_detail_profession.author','ttaxe_detail_profession.refUser',
            "ttaxe_profession.nom_profession",'id_Secteur',"ttaxe_secteur.nom_secteur"
            ,'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus')
            ->selectRaw("DATE_FORMAT(ttaxe_detail_profession.created_at,'%d/%M/%Y') as dateOperation")
            ->where([
                ['colNom_Ese', 'like', '%'.$query.'%'],
                ['ttaxe_detail_profession.id_personne',$refEntete]
            ])                    
            ->orderBy("ttaxe_detail_profession.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('ttaxe_detail_profession')
            ->join('ttaxe_profession','ttaxe_profession.id','=','ttaxe_detail_profession.id_profession')
            ->join('ttaxe_secteur','ttaxe_secteur.id','=','ttaxe_profession.id_Secteur')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_detail_profession.id_personne')
            ->select("ttaxe_detail_profession.id",'id_personne','id_profession','date_debut','date_fin',
            'ttaxe_detail_profession.author','ttaxe_detail_profession.refUser',
            "ttaxe_profession.nom_profession",'id_Secteur',"ttaxe_secteur.nom_secteur"
            ,'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus')
            ->selectRaw("DATE_FORMAT(ttaxe_detail_profession.created_at,'%d/%M/%Y') as dateOperation")            
            ->Where('ttaxe_detail_profession.id_personne',$refEntete)    
            ->orderBy("ttaxe_detail_profession.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    




    function fetch_single($id)
    {
        $data = DB::table('ttaxe_detail_profession')
        ->join('ttaxe_profession','ttaxe_profession.id','=','ttaxe_detail_profession.id_profession')
        ->join('ttaxe_secteur','ttaxe_secteur.id','=','ttaxe_profession.id_Secteur')
        ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_detail_profession.id_personne')
        ->select("ttaxe_detail_profession.id",'id_personne','id_profession','date_debut','date_fin',
        'ttaxe_detail_profession.author','ttaxe_detail_profession.refUser',
        "ttaxe_profession.nom_profession",'id_Secteur',"ttaxe_secteur.nom_secteur"
        ,'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
        'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
        'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
        'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus')
        ->selectRaw("DATE_FORMAT(ttaxe_detail_profession.created_at,'%d/%M/%Y') as dateOperation")      
        ->where('ttaxe_detail_profession.id', $id)
        ->get();

        return response($data, 200);
    }


    function insert_data(Request $request)
    {
       //'id','id_personne','id_profession','date_debut','date_fin','author','refUser'
        $data = ttaxe_detail_profession::create([     
            'id_personne'    =>  $request->id_personne, 
            'id_profession'    =>  $request->id_profession,
            'date_debut'    =>  $request->date_debut,                      
            'date_fin'    =>  $request->date_fin,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }
    
    function update_data(Request $request, $id)
    {        
        $data = ttaxe_detail_profession::where('id', $id)->update([
            'id_personne'    =>  $request->id_personne, 
            'id_profession'    =>  $request->id_profession,
            'date_debut'    =>  $request->date_debut,                      
            'date_fin'    =>  $request->date_fin,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }

    function delete_data($id)
    {
        $data = ttaxe_detail_profession::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
