<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\ttaxe_paiement;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class ttaxe_paiementController extends Controller
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

    // 'id','montant','montantLettre','motif','dateOperation','refEse','refCompte','refAgent','author' ttaxe_paiement

    public function all(Request $request)
    {    
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('ttaxe_paiement')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
            ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
            ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
            ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
            ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
            'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
            "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
            'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
            'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
            'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
            ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
            'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
            "tperso_annee.active")
            ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("ttaxe_paiement.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('ttaxe_paiement')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
            ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
            ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
            ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
            ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
            'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
            "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
            'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
            'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
            'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
            ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
            'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
            "tperso_annee.active") 
            ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
            ->orderBy("ttaxe_paiement.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }

    public function all_jour(Request $request)
    {
            $current = Carbon::now(); 
            $formattedDate = $current->format('Y-m-d');
            
            if (!is_null($request->get('query'))) 
            {
            
            $query = $this->Gquery($request);
            $data = DB::table('ttaxe_paiement')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
            ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
            ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
            ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
            ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
            'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
            "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
            'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
            'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
            'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
            ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
            'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
            "tperso_annee.active")   
            ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['ttaxe_paiement.created_at','>=', $formattedDate]
                ])               
                ->orderBy("ttaxe_paiement.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('ttaxe_paiement')
                ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
                ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
                ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
                ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
                ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
                ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
                'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
                "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
                'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
                'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
                'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
                ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
                'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
                "tperso_annee.active")  
                ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
                ->where([
                    ['ttaxe_paiement.created_at','>=', $formattedDate]
                ]) 
                ->orderBy("ttaxe_paiement.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        

    }


    public function all_filter(Request $request)
    {

        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            
            if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('ttaxe_paiement')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
            ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
            ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
            ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
            ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
            'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
            "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
            'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
            'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
            'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
            ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
            'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
            "tperso_annee.active")
            ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")   
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['ttaxe_paiement.created_at','>=', $date1],
                    ['ttaxe_paiement.created_at','<=', $date2],
                ])               
                ->orderBy("ttaxe_paiement.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('ttaxe_paiement')
                ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
                ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
                ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
                ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
                ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
                ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
                'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
                "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
                'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
                'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
                'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
                ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
                'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
                "tperso_annee.active")  
                ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
                ->where([
                    ['ttaxe_paiement.created_at','>=', $date1],
                    ['ttaxe_paiement.created_at','<=', $date2],
                ]) 
                ->orderBy("ttaxe_paiement.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{} 
    }


    public function all_compte_filter(Request $request)
    { 
               
        if ($request->get('date1') && $request->get('date2') && $request->get('refCompte'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            $refCompte = $request->get('refCompte');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('ttaxe_paiement')
                ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
                ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
                ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
                ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
                ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
                ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
                'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
                "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
                'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
                'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
                'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
                ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
                'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
                "tperso_annee.active") 
                ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")  
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['ttaxe_paiement.created_at','>=', $date1],
                    ['ttaxe_paiement.created_at','<=', $date2],
                    ['ttaxe_paiement.refCompte','=', $refCompte],
                ])               
                ->orderBy("ttaxe_paiement.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('ttaxe_paiement')
                ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
                ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
                ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
                ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
                ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
                ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
                'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
                "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
                'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
                'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
                'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
                ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
                'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
                "tperso_annee.active") 
                ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")  
                ->where([
                    ['ttaxe_paiement.created_at','>=', $date1],
                    ['ttaxe_paiement.created_at','<=', $date2],
                    ['ttaxe_paiement.refCompte','=', $refCompte],
                ]) 
                ->orderBy("ttaxe_paiement.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }


    public function fetch_detail_entete(Request $request,$refEse)
    {

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('ttaxe_paiement')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
            ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
            ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
            ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
            ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
            'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
            "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
            'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
            'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
            'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
            ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
            'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
            "tperso_annee.active")
            ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refEse',$refEse]
            ])                    
            ->orderBy("ttaxe_paiement.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('ttaxe_paiement')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
            ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
            ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
            ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
            ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
            'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
            "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
            'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
            'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
            'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
            ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
            'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
            "tperso_annee.active") 
            ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")               
            ->Where('refEse',$refEse)    
            ->orderBy("ttaxe_paiement.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    




    function fetch_single($id)
    {
        $data = DB::table('ttaxe_paiement')
        ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
        ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
        ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
        ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
        ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
        ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
        'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
        "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
        'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
        'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
        'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
        ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
        'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee","tperso_annee.active")  
        ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")      
        ->where('ttaxe_paiement.id', $id)
        ->get();

        return response($data, 200);
    }


    function fetch_paiementtaxe_agent($refAgent)
    {
        $data = DB::table('ttaxe_paiement')
        ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
        ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
        ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
        ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
        ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
        ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
        'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
        "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
        'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
        'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
        'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
        ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
        'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
        "tperso_annee.active")
        ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
        ->where('ttaxe_paiement.refAgent', $refAgent)
        ->orderBy("ttaxe_paiement.id", "desc")
        ->get();

        return response($data, 200);
    }


    function insert_data(Request $request)
    {
       
        $current = Carbon::now(); 
        $montant = 0;
        $montant2 = 0;
        $idCategorie =0;
        $montantLettre = '';
        $motif = '';

        $data3 =  DB::table('ttaxe_contribuable')
        ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_contribuable.ColRefCat') 
        ->select('ttaxe_categorie.id as idCategorie','prix_categorie','prix_categorie2',
        'ttaxe_categorie.designation as categorietaxe')
        ->where([
           ['ttaxe_contribuable.id','=', $request->refEse]
        ])    
        ->get(); 

        foreach ($data3 as $row) 
        {
            $montant = $row->prix_categorie;
            $montant2 = $row->prix_categorie2;
            $idCategorie =$row->idCategorie;
            $motif =$row->categorietaxe;                  
        }

        $montantLettre = $this->chiffreEnLettre($request->montant);

        // ,'refMois','refAnnee' 'id','montant','montantLettre','motif','dateOperation','refEse','refCompte','refAgent','compteur','author' ttaxe_paiement
        $data = ttaxe_paiement::create([
            'montant'    =>  $montant,
            // 'montant'    =>  $request->montant,
            'montantLettre'    =>  $montantLettre,            
            'dateOperation'    =>  $current, 
            'refCompte'    =>  $idCategorie,  
            'motif'    =>  $motif,          
            'refEse'    =>  $request->refEse, 
            'refMois'    =>  $request->refMois,
            'refAnnee'    =>  $request->refAnnee,                      
            'refAgent'    =>  $request->refAgent,
            'compteur'    =>  0,
            'compteur2'    =>  0,
            'author'       =>  $request->author,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }

//'id','montant','montantLettre','motif','dateOperation','refEse','refCompte','refAgent','compteur','author' ttaxe_paiement
    function update_data(Request $request, $id)
    {        
        $data = ttaxe_paiement::where('id', $id)->update([
            'montant'    =>  $request->montant,
            'montantLettre'    =>  $request->montantLettre,
            'motif'    =>  $request->motif,
            'dateOperation'    =>  $request->dateOperation,
            'refEse'    => $request->refEse,
            'refMois'    =>  $request->refMois,
            'refAnnee'    =>  $request->refAnnee,
            'refCompte'    =>  $request->refCompte,
            'refAgent'    =>  $request->refAgent,
            'author'       =>  'Admin',
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }

    function update_compter(Request $request)
    {        
        $data = ttaxe_paiement::where('id', $request->id)->update([
            'compteur'    =>  $request->compteur,
            'compteur2'    =>  $request->compteur
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }

    function delete_data($id)
    {
        $data = ttaxe_paiement::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
