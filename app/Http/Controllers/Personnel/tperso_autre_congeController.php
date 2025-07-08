<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_autre_conge;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_autre_congeController extends Controller
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

            $query = $this->Gquery($request);
            $data = DB::table('tperso_autre_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_autre_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_autre_conge.id","autreDetail","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_autre_conge.author","refAnne","refEnteteConge",
            "dateAffectation","codeAgent","numCNSS","autresDetail","refAgent","refServicePerso","refCategorieAgent",
            "matricule_agent","noms_agent","dateJourAbsent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")             
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_entete_conge.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_autre_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_autre_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_autre_conge.id","autreDetail","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_autre_conge.author","refAnne","refEnteteConge",   
            
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","dateJourAbsent","dateDernierJour",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")             
            ->orderBy("tperso_entete_conge.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_affect_autreConge(Request $request,$refEnteteConge)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_autre_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_autre_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_autre_conge.id","autreDetail","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_autre_conge.author","refAnne","refEnteteConge",   
            
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","dateJourAbsent","dateDernierJour",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")            
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refEnteteConge',$refEnteteConge]
            ])                    
            ->orderBy("tperso_entete_conge.id", "desc")
            ->paginate(10);

            return response($data, 200);         

        }
        else{
      
            $data = DB::table('tperso_autre_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_autre_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_autre_conge.id","autreDetail","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_autre_conge.author","refAnne","refEnteteConge",   
            
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","dateJourAbsent","dateDernierJour",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->Where('refEnteteConge',$refEnteteConge)    
            ->orderBy("tperso_entete_conge.id", "desc")
            ->paginate(10);

            return response($data, 200);        
 
        }

    }    
    

    function fetch_single($id)
    {

        $data = DB::table('tperso_autre_conge')
        ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_autre_conge.refEnteteConge')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
        ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
        ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_autre_conge.id","autreDetail","dateDernierJour","dateRetour","controle",
        "agent","remplacement","chefService","hierarchie","tperso_autre_conge.author","refAnne","refEnteteConge",   
        "dateAffectation","codeAgent","numCNSS","autresDetail",
        "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
        "noms_agent","dateJourAbsent","dateDernierJour",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")        
        ->where('tperso_autre_conge.id', $id)
        ->get();

        return response($data, 200);
    }



    function insert_data(Request $request)
    {

        $data = tperso_autre_conge::create([
            'refEnteteConge'       =>  $request->refEnteteConge,
            'autreDetail'    =>  $request->autreDetail,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_autre_conge::where('id', $id)->update([
            'refEnteteConge'       =>  $request->refEnteteConge,
            'autreDetail'    =>  $request->autreDetail,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_autre_conge::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
