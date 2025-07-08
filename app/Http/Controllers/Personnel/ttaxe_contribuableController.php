<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel\{ttaxe_contribuable};
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class ttaxe_contribuableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }


    public function index(Request $request)
    {       

        if (!is_null($request->get('query'))) {
                # code...
            $query = $this->Gquery($request);

            $data = DB::table('ttaxe_contribuable')  
            ->leftjoin('ttaxe_encondeur' , 'ttaxe_encondeur.code_encodeur','=','ttaxe_contribuable.author')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_contribuable.ColRefCat')          
            ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("ttaxe_contribuable.id",'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus','photo','slug',
            'author','ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2', 
            "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays",
            "provinces.nomProvince","pays.nomPays",'entreprisePhone1','entreprisePhone2',
            'entrepriseMail','axes_encodeur','solde','Details','ttaxe_contribuable.created_at'
            ,'noms as Encodeur','telephone as TelEncodeur','code_encodeur')
            ->where('colNom_Ese', 'like', '%'.$query.'%')        
            ->orWhere('noms', 'like', '%'.$query.'%')       
            ->orWhere('ttaxe_categorie.designation', 'like', '%'.$query.'%')
            ->orWhere('colRaisonSociale_Ese', 'like', '%'.$query.'%')
            ->orWhere('colId_Ese', 'like', '%'.$query.'%')
            ->orWhere('nomQuartier', 'like', '%'.$query.'%')
            ->orderBy("ttaxe_contribuable.id", "desc")
            ->paginate(80);

            return response($data, 200);
           
 
        }
        else{
            $data = DB::table('ttaxe_contribuable')  
            ->leftjoin('ttaxe_encondeur' , 'ttaxe_encondeur.code_encodeur','=','ttaxe_contribuable.author')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_contribuable.ColRefCat')          
            ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("ttaxe_contribuable.id",'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus','photo','slug',
            'author','ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2', 
            "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays",
            "provinces.nomProvince","pays.nomPays",'entreprisePhone1','entreprisePhone2',
            'entrepriseMail','axes_encodeur','solde','Details','ttaxe_contribuable.created_at'
            ,'noms as Encodeur','telephone as TelEncodeur','code_encodeur')
            ->orderBy("ttaxe_contribuable.id", "desc")
            ->paginate(80);

             return response($data, 200);
            }

    }
    
    public function Profilettaxe_contribuable($id, Request $request)
    {
        //
        $data = DB::table('ttaxe_contribuable')  
            ->leftjoin('ttaxe_encondeur' , 'ttaxe_encondeur.code_encodeur','=','ttaxe_contribuable.author')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_contribuable.ColRefCat')          
            ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("ttaxe_contribuable.id",'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus','photo','slug',
            'author','ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2', 
            "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays",
            "provinces.nomProvince","pays.nomPays",'entreprisePhone1','entreprisePhone2',
            'entrepriseMail','axes_encodeur','solde','Details','ttaxe_contribuable.created_at'
            ,'noms as Encodeur','telephone as TelEncodeur','code_encodeur')
        ->where([
            ['ttaxe_contribuable.id', $id]
        ])
        ->get();

        return response()->json(['data'  =>  $data]);
        
    }

    public function filter_contribuable(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('ttaxe_contribuable')  
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_contribuable.ColRefCat')          
            ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE 
            ->select("ttaxe_contribuable.id",'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus','photo','slug',
            'author','ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2', 
            "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","axes_encodeur",
            "provinces.nomProvince","pays.nomPays","solde","Details")
            ->where('colNom_Ese', 'like', '%'.$query.'%')               
            ->orWhere('ttaxe_categorie.designation', 'like', '%'.$query.'%')
            ->orWhere('colRaisonSociale_Ese', 'like', '%'.$query.'%')
            ->orWhere('colId_Ese', 'like', '%'.$query.'%')
            ->orWhere('nomQuartier', 'like', '%'.$query.'%')
            ->get();
    
            return response()->json(['data'  =>  $data]);          
        
        
        }

    }

    function fetch_list_contribuable()
    {        
        $data = DB::table('ttaxe_contribuable') 
        ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_contribuable.ColRefCat')
        ->select("ttaxe_contribuable.id",'colId_Ese','colIdNat_Ese','colRCCM_Ese',
        'colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese',
        'ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
        'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus',
        'photo','slug','author','entreprisePhone1','entreprisePhone2','entrepriseMail',
        'Details','axes_encodeur','solde','ttaxe_categorie.designation as categorietaxe',
        'prix_categorie','prix_categorie2')
        // ->orderBy("colNom_Ese", "asc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

    }


    function insertSync(Request $request)
    {
        // $stringToSlug=substr($request->colNom_Ese.''.$request->colNom_Ese,0,16).'-'.$this->generateOpt(8);
        // $slug =$this->makeSlug($stringToSlug);
        $slug = '0000';
        $current = Carbon::now(); 
        //$codeEse = $this->makeSlug('ttaxe_contribuable');  axes_encodeur
        $codeEse = 1;
        $proprietaire = $request->colProprietaire_Ese;
        ttaxe_contribuable::create([
            'colId_Ese'  =>  $request->colId_Ese,
            'colIdNat_Ese'    =>  $proprietaire,
            'colRCCM_Ese'         =>  $proprietaire,                
            'colNom_Ese'      =>  $proprietaire,                
            'colRaisonSociale_Ese'  =>  $proprietaire, 
            'colFormeJuridique_Ese'  =>  $proprietaire,
            'colGenreActivite_Ese'  =>  $proprietaire,
            'ColRefCat'  =>  $request->ColRefCat,
            'ColRefQuartier'  =>  $request->ColRefQuartier,
            'colQuartier_Ese'  =>  $request->colQuartier_Ese,
            'colAdresseEntreprise_Ese'  =>  $request->colAdresseEntreprise_Ese,
            'colProprietaire_Ese'  =>  $request->colProprietaire_Ese,
            'colCreatedBy_Ese'  =>  $request->colCreatedBy_Ese,
            'author'         =>  $request->author,
            'colDateSave_Ese'  =>  $request->colDateSave_Ese, 
            'entreprisePhone1' =>  $request->entreprisePhone1,
            'entreprisePhone2' =>  $request->entreprisePhone2,
            'entrepriseMail' =>  $request->entrepriseMail,
            'Details' =>  $request->Details,
            'axes_encodeur' =>  'Axe1',
            'current_timestamp'  =>  $current, 
            'colStatus'  =>  1,
            'photo'         =>  'avatar.png',
            'slug'          =>  $slug,
                 
        ]);
        return $this->msgJson('Information ajoutée avec succès');
        //Details
    }

    function insertData(Request $request)
    {
        $stringToSlug=substr($request->colNom_Ese.''.$request->colNom_Ese,0,16).'-'.$this->generateOpt(8);
        $slug =$this->makeSlug($stringToSlug);
        //$slug = '0000';
        $current = Carbon::now(); 
        //$codeEse = $this->makeSlug('ttaxe_contribuable');
        $codeEse = 1;

        $colGenreActivite_Ese='';
        $colQuartier_Ese='';

        $data3 =  DB::table('ttaxe_categorie')
        ->select("ttaxe_categorie.id",'designation','prix_categorie',"ttaxe_categorie.created_at")
        ->where([
           ['ttaxe_categorie.id','=', $request->refEse]
        ])    
        ->get(); 

        foreach ($data3 as $row) 
        {
            $montant = $row->prix_categorie;
            $idCategorie =$row->idCategorie;
            $motif =$row->categorietaxe;                  
        }



        if (!is_null($request->image)) 
        {

            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->colNom_Ese.''.$formData->colNom_Ese,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);


            $colGenreActivite_Ese='';
            $colQuartier_Ese='';
    
            $data3 =  DB::table('ttaxe_categorie')
            ->select("ttaxe_categorie.id",'designation','prix_categorie',"ttaxe_categorie.created_at")
            ->where([
               ['ttaxe_categorie.id','=', $formData->ColRefCat]
            ])    
            ->get(); 
    
            foreach ($data3 as $row) 
            {
                $colGenreActivite_Ese = $row->designation;
            }

            $data4 =  DB::table('quartiers')
            ->select('quartiers.id','quartiers.idCommune','quartiers.nomQuartier')
            ->where([
               ['quartiers.id','=', $formData->ColRefQuartier]
            ])    
            ->get();    
            foreach ($data4 as $row) 
            {
                $colQuartier_Ese = $row->nomQuartier;
            }


            ttaxe_contribuable::create([
                'colId_Ese'  =>  $formData->colId_Ese,
                'colIdNat_Ese'    =>  $formData->colIdNat_Ese,
                'colRCCM_Ese'         =>  $formData->colRCCM_Ese,                
                'colNom_Ese'      =>  $formData->colNom_Ese,                
                'colRaisonSociale_Ese'  =>  $formData->colRaisonSociale_Ese, 
                'colFormeJuridique_Ese'  =>  $formData->colFormeJuridique_Ese,
                'colGenreActivite_Ese'  =>  $colGenreActivite_Ese,
                'ColRefCat'  =>  $formData->ColRefCat,
                'ColRefQuartier'  =>  $formData->ColRefQuartier,
                'colQuartier_Ese'  =>  $colQuartier_Ese,
                'colAdresseEntreprise_Ese'  =>  $formData->colAdresseEntreprise_Ese,
                'colProprietaire_Ese'  =>  $formData->colProprietaire_Ese,
                'entreprisePhone1' =>  $formData->entreprisePhone1,
                'entreprisePhone2' =>  $formData->entreprisePhone2,
                'entrepriseMail' =>  $formData->entrepriseMail,
                'Details' =>  $formData->Details,
                'axes_encodeur'  =>  $formData->axes_encodeur,
                'colCreatedBy_Ese'  =>  $formData->author,                
                'colDateSave_Ese'  =>  $current, 
                'current_timestamp'  =>  $current, 
                'colStatus'  =>  1,
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'author'         =>  $formData->author     
            ]);
            return $this->msgJson('Information ajoutée avec succès');
        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->colNom_Ese.''.$formData->colNom_Ese,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);


            $colGenreActivite_Ese='';
            $colQuartier_Ese='';
    
            $data3 =  DB::table('ttaxe_categorie')
            ->select("ttaxe_categorie.id",'designation','prix_categorie',"ttaxe_categorie.created_at")
            ->where([
               ['ttaxe_categorie.id','=', $formData->ColRefCat]
            ])    
            ->get(); 
    
            foreach ($data3 as $row) 
            {
                $colGenreActivite_Ese = $row->designation;
            }

            $data4 =  DB::table('quartiers')
            ->select('quartiers.id','quartiers.idCommune','quartiers.nomQuartier')
            ->where([
               ['quartiers.id','=', $formData->ColRefQuartier]
            ])    
            ->get();    
            foreach ($data4 as $row) 
            {
                $colQuartier_Ese = $row->nomQuartier;
            }


            ttaxe_contribuable::create([
                'colId_Ese'  =>  $formData->colId_Ese,
                'colIdNat_Ese'    =>  $formData->colIdNat_Ese,
                'colRCCM_Ese'         =>  $formData->colRCCM_Ese,                
                'colNom_Ese'      =>  $formData->colNom_Ese,                
                'colRaisonSociale_Ese'  =>  $formData->colRaisonSociale_Ese, 
                'colFormeJuridique_Ese'  =>  $formData->colFormeJuridique_Ese,
                'colGenreActivite_Ese'  =>  $colGenreActivite_Ese,
                'ColRefCat'  =>  $formData->ColRefCat,
                'ColRefQuartier'  =>  $formData->ColRefQuartier,
                'colQuartier_Ese'  =>  $colQuartier_Ese,
                'colAdresseEntreprise_Ese'  =>  $formData->colAdresseEntreprise_Ese,
                'colProprietaire_Ese'  =>  $formData->colProprietaire_Ese,
                'entreprisePhone1' =>  $formData->entreprisePhone1,
                'entreprisePhone2' =>  $formData->entreprisePhone2,
                'entrepriseMail' =>  $formData->entrepriseMail,
                'Details' =>  $formData->Details,
                'axes_encodeur'  =>  $formData->axes_encodeur,
                'colCreatedBy_Ese'  => $formData->author,
                'colDateSave_Ese'  =>  $current, 
                'current_timestamp'  =>  $current, 
                'colStatus'  =>  1,
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'author'         =>  $formData->author  
            ]);
            return $this->msgJson('Information ajoutée avec succès');

        }

    }

    function updateData(Request $request)
    {
        $current = Carbon::now(); 
        $codeEse = $this->makeSlug('ttaxe_contribuable');

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->colNom_Ese.''.$formData->colNom_Ese,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            $colGenreActivite_Ese='';
            $colQuartier_Ese='';
    
            $data3 =  DB::table('ttaxe_categorie')
            ->select("ttaxe_categorie.id",'designation','prix_categorie',"ttaxe_categorie.created_at")
            ->where([
               ['ttaxe_categorie.id','=', $formData->ColRefCat]
            ])    
            ->get(); 
    
            foreach ($data3 as $row) 
            {
                $colGenreActivite_Ese = $row->designation;
            }

            $data4 =  DB::table('quartiers')
            ->select('quartiers.id','quartiers.idCommune','quartiers.nomQuartier')
            ->where([
               ['quartiers.id','=', $formData->ColRefQuartier]
            ])    
            ->get();    
            foreach ($data4 as $row) 
            {
                $colQuartier_Ese = $row->nomQuartier;
            }
           
            ttaxe_contribuable::where('id',$formData->id)->update([
                'colIdNat_Ese'    =>  $formData->colIdNat_Ese,
                'colRCCM_Ese'         =>  $formData->colRCCM_Ese,                
                'colNom_Ese'      =>  $formData->colNom_Ese,                
                'colRaisonSociale_Ese'  =>  $formData->colRaisonSociale_Ese, 
                'colFormeJuridique_Ese'  =>  $formData->colFormeJuridique_Ese,
                'colGenreActivite_Ese'  =>  $colGenreActivite_Ese,
                'ColRefCat'  =>  $formData->ColRefCat,
                'ColRefQuartier'  =>  $formData->ColRefQuartier,
                'colQuartier_Ese'  =>  $colQuartier_Ese,
                'colAdresseEntreprise_Ese'  =>  $formData->colAdresseEntreprise_Ese,
                'colProprietaire_Ese'  =>  $formData->colProprietaire_Ese,
                'entreprisePhone1' =>  $formData->entreprisePhone1,
                'entreprisePhone2' =>  $formData->entreprisePhone2,
                'entrepriseMail' =>  $formData->entrepriseMail,
                'Details' =>  $formData->Details,
                'axes_encodeur'  =>  $formData->axes_encodeur,
                'colCreatedBy_Ese'  =>  $formData->author,
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'author'         =>  $formData->author   
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           
            $stringToSlug=substr($formData->colNom_Ese.''.$formData->colNom_Ese,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            $colGenreActivite_Ese='';
            $colQuartier_Ese='';
    
            $data3 =  DB::table('ttaxe_categorie')
            ->select("ttaxe_categorie.id",'designation','prix_categorie',"ttaxe_categorie.created_at")
            ->where([
               ['ttaxe_categorie.id','=', $formData->ColRefCat]
            ])    
            ->get(); 
    
            foreach ($data3 as $row) 
            {
                $colGenreActivite_Ese = $row->designation;
            }

            $data4 =  DB::table('quartiers')
            ->select('quartiers.id','quartiers.idCommune','quartiers.nomQuartier')
            ->where([
               ['quartiers.id','=', $formData->ColRefQuartier]
            ])    
            ->get();    
            foreach ($data4 as $row) 
            {
                $colQuartier_Ese = $row->nomQuartier;
            }

            ttaxe_contribuable::where('id',$formData->id)->update([
                'colIdNat_Ese'    =>  $formData->colIdNat_Ese,
                'colRCCM_Ese'         =>  $formData->colRCCM_Ese,                
                'colNom_Ese'      =>  $formData->colNom_Ese,                
                'colRaisonSociale_Ese'  =>  $formData->colRaisonSociale_Ese, 
                'colFormeJuridique_Ese'  =>  $formData->colFormeJuridique_Ese,
                'colGenreActivite_Ese'  =>  $colGenreActivite_Ese,
                'ColRefCat'  =>  $formData->ColRefCat,
                'ColRefQuartier'  =>  $formData->ColRefQuartier,
                'colQuartier_Ese'  =>  $colQuartier_Ese,
                'colAdresseEntreprise_Ese'  =>  $formData->colAdresseEntreprise_Ese,
                'colProprietaire_Ese'  =>  $formData->colProprietaire_Ese,
                'entreprisePhone1' =>  $formData->entreprisePhone1,
                'entreprisePhone2' =>  $formData->entreprisePhone2,
                'entrepriseMail' =>  $formData->entrepriseMail,
                'Details' =>  $formData->Details,
                'axes_encodeur'  =>  $formData->axes_encodeur,
                'colCreatedBy_Ese'  =>  $formData->author,
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'author'         =>  $formData->author 
            ]);
            return $this->msgJson('Modifcation avec succès');

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
        $data = DB::table('ttaxe_contribuable')  
        ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_contribuable.ColRefCat')          
        ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("ttaxe_contribuable.id",'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
        'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
        'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
        'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus','photo','slug',
        'author','ttaxe_categorie.designation as categorietaxe','prix_categorie', 
        "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays",
        "provinces.nomProvince","pays.nomPays",'entreprisePhone1','entreprisePhone2',
        'entrepriseMail','axes_encodeur','Details')
        ->where('ttaxe_contribuable.id', $id)->get();

        
        return response()->json(['data'  =>  $data]);

    }

    function fetch_contribuable_bycode(Request $request)
    {
        if (($request->get('colId_Ese'))) 
        {
            $data = DB::table('ttaxe_contribuable')  
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_contribuable.ColRefCat')          
            ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("ttaxe_contribuable.id",'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese',
            'colRaisonSociale_Ese','colFormeJuridique_Ese','colGenreActivite_Ese','ColRefCat',
            'ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese','colProprietaire_Ese',
            'colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus','photo','slug',
            'author','ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2', 
            "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays",
            "provinces.nomProvince","pays.nomPays",'entreprisePhone1','entreprisePhone2',
            'entrepriseMail','axes_encodeur','solde','Details')
            ->where('ttaxe_contribuable.colId_Ese', $request->colId_Ese)
            ->orderBy("ttaxe_contribuable.id", "desc")
            ->get();
    
            return response($data, 200);
        }
        else
        {
            
        }
       
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
        $data = ttaxe_contribuable::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');

        // $data = ttaxe_contribuable::where("id", $id)->delete();

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function RestoreDatattaxe_contribuable($id, $connected)
    {
        //
        $data = ttaxe_contribuable::where('id',$id)->update([
            'statut'                =>  0,
            'id_user_delete'        =>  $connected,
        ]);
        return $this->msgJson('Restauration des données avec succès!!!');

    }





}
