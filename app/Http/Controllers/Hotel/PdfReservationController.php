<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;
class PdfReservationController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

     

    //=============== FACTURE HOTEL =====================================================================

    function pdf_facture_hotel(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoFactureHotel($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoFactureHotel($id)
    {

                $titres="BON D'ENTREE CAISSE";

                $date_entree='';
                $date_sortie='';
                $heure_debut='';                
                $heure_sortie='';
                $prix_unitaire='';
                $reduction='';
                $type_reservation='';
                $nom_accompagner='';
                $pays_provenance='';
                $author='';
                $noms='';
                $sexe='';
                $contact='';
                $mail='';
                $adresse='';
                $pieceidentite='';
                $numeroPiece='';
                $dateLivrePiece='';
                $lieulivraisonCarte='';
                $nationnalite='';
                $datenaissance='';
                $lieunaissance='';
                $profession='';
                $occupation='';
                $nombreEnfant='';
                $dateArriverGoma='';
                $arriverPar='';
                $devise='';
                $CategorieClient='';
                $nom_chambre='';
                $numero_chambre='';
                $codeOperation='';
                $prix_unitaireFC='';
                $NombreJour='';
                $prixTotalSans='';
                $prixTotal='';
                $prixTotalFC='';
                $totalFacture='';
                $totalPaie='';
                $RestePaie='';
                $RestePaieFC='';
                $dateReservation='';
                $ClasseChambre='';
                
                $data = DB::table('thotel_reservation_chambre')
                ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refClient')
                ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
                ->join('tvente_client','tvente_client.id','=','thotel_reservation_chambre.refClient')
                ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        
                ->select('thotel_reservation_chambre.id','refClient','refChmabre','date_entree','date_sortie',
                'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
                'type_reservation','nom_accompagner','pays_provenance',
                'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at','noms','sexe',
                'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
                'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
                'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
                'thotel_reservation_chambre.devise','thotel_reservation_chambre.taux',
                'tvente_categorie_client.designation as CategorieClient', 
                "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
                "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre")
                ->selectRaw('CONCAT("RCH",YEAR(thotel_reservation_chambre.created_at),"",MONTH(thotel_reservation_chambre.created_at),"00",thotel_reservation_chambre.id) as codeOperation')
                ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFC')
                ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
                ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSans')
                ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotal')
                ->selectRaw('((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFC')
                ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
                ->selectRaw('IFNULL(paie,0) as totalPaie')
                ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(paie,0)) as RestePaie')
                ->selectRaw('((IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(paie,0))/thotel_reservation_chambre.taux) as RestePaieFC')
                ->where('thotel_reservation_chambre.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $date_entree=$row->date_entree;
                    $date_sortie=$row->date_sortie;
                    $heure_debut=$row->heure_debut;                
                    $heure_sortie=$row->heure_sortie;
                    $prix_unitaire=$row->prix_unitaire;
                    $reduction=$row->reduction;
                    $type_reservation=$row->type_reservation;
                    $nom_accompagner=$row->nom_accompagner;
                    $pays_provenance=$row->pays_provenance;
                    $author=$row->author;
                    $noms=$row->noms;
                    $sexe=$row->sexe;
                    $contact=$row->contact;
                    $mail=$row->mail;
                    $adresse=$row->adresse;
                    $pieceidentite=$row->pieceidentite;
                    $numeroPiece=$row->numeroPiece;
                    $dateLivrePiece=$row->dateLivrePiece;
                    $lieulivraisonCarte=$row->lieulivraisonCarte;
                    $nationnalite=$row->nationnalite;
                    $datenaissance=$row->datenaissance;
                    $lieunaissance=$row->lieunaissance;
                    $profession=$row->profession;
                    $occupation=$row->occupation;
                    $nombreEnfant=$row->nombreEnfant;
                    $dateArriverGoma=$row->dateArriverGoma;
                    $arriverPar=$row->arriverPar;
                    $devise=$row->devise;
                    $CategorieClient=$row->CategorieClient;
                    $nom_chambre=$row->nom_chambre;
                    $numero_chambre=$row->numero_chambre;
                    $codeOperation=$row->codeOperation;
                    $prix_unitaireFC=$row->prix_unitaireFC;
                    $NombreJour=$row->NombreJour;
                    $prixTotalSans=$row->prixTotalSans;
                    $prixTotal=$row->prixTotal;
                    $prixTotalFC=$row->prixTotalFC;
                    $totalFacture=$row->totalFacture;
                    $totalPaie=$row->totalPaie;
                    $RestePaie=$row->RestePaie;
                    $RestePaieFC=$row->RestePaieFC;
                    $dateReservation=$row->created_at;
                    $ClasseChambre=$row->ClasseChambre;
                    }


                //Info Entreprise
                $nomEse='';
                $adresseEse='';
                $Tel1Ese='';
                $Tel2Ese='';
                $siteEse='';
                $emailEse='';
                $idNatEse='';
                $numImpotEse='';
                $rccEse='';
                $siege='';
                $busnessName='';
                $pic='';
                $pic2 = $this->displayImg("fichier", 'logo.png');
                $logo='';
        
                $data1 = DB::table('entreprises')
                ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
                ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
        
                ->join('pays','pays.id','=','entreprises.idPays')
                ->join('provinces','provinces.id','=','entreprises.idProvince')
                ->join('users','users.id','=','entreprises.ceo')        
                ->select('entreprises.id as id','entreprises.id as idEntreprise',
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
                'entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
                'entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
                'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
                'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
                    //forme
                    'forme_juridiques.nomForme','secteurs.nomSecteur',
                    //users
                    'users.name','users.email','users.avatar','users.telephone','users.adresse',
                    //
                    'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
                ->get();
                $output='';
                foreach ($data1 as $row1) 
                {                                
                    $nomEse=$row1->nomEntreprise;
                    $adresseEse=$row1->adresseEntreprise;
                    $Tel1Ese=$row1->telephoneEntreprise;
                    $Tel2Ese=$row1->telephone;
                    $siteEse=$row1->siteweb;
                    $emailEse=$row1->emailEntreprise;
                    $idNatEse=$row1->rccm;
                    $numImpotEse=$row1->rccm;
                    $busnessName=$row1->nomSecteur;
                    $rccmEse=$row1->rccm;
                    $pic = $this->displayImg("fichier", 'logo.png');
                    $siege=$row1->nomForme;         
                }

        
                $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                  <title>FactureHotel</title>
                  <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                  <style type="text/css">
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs69040D7 {color:#000000;background-color:transparent;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
                    .cs76F63DEB {color:#000000;background-color:transparent;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                  </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:700px;height:421px;position:relative;">
                  <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:9px;"></td>
                    <td style="height:0px;width:5px;"></td>
                    <td style="height:0px;width:70px;"></td>
                    <td style="height:0px;width:39px;"></td>
                    <td style="height:0px;width:131px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:68px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:103px;"></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:514px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:13px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:169px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:169px;height:144px;">
                      <img alt="" src="'.$pic2.'" style="width:169px;height:144px;" /></div>
                    </td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:514px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:514px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:514px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:514px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:514px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:514px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs76F63DEB" style="width:66px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Num&nbsp;:</nobr></td>
                    <td class="cs76F63DEB" colspan="6" style="width:358px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$codeOperation.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs69040D7" style="width:66px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Client&nbsp;:</nobr></td>
                    <td class="cs69040D7" colspan="6" style="width:358px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$noms.'&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;'.$contact.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs69040D7" style="width:66px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Res.&nbsp;:</nobr></td>
                    <td class="cs69040D7" colspan="6" style="width:358px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$dateReservation.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs69040D7" style="width:66px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Type&nbsp;Res.&nbsp;:</nobr></td>
                    <td class="cs69040D7" colspan="6" style="width:358px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$type_reservation.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:5px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Num&#233;ro&nbsp;Chambre</nobr></td>
                    <td class="csD149F8AB" style="width:130px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Classe</nobr></td>
                    <td class="csD149F8AB" style="width:86px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Entr&#233;e</nobr></td>
                    <td class="csD149F8AB" colspan="2" style="width:77px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Sortie</nobr></td>
                    <td class="csD149F8AB" colspan="2" style="width:46px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Jours</nobr></td>
                    <td class="csD149F8AB" style="width:58px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU&nbsp;(USD)</nobr></td>
                    <td class="csD149F8AB" colspan="2" style="width:71px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT&nbsp;(USD)</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$nom_chambre.'</nobr></td>
                    <td class="csD149F8AB" style="width:130px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$ClasseChambre.'</td>
                    <td class="csD149F8AB" style="width:86px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$date_entree.'</nobr></td>
                    <td class="csD149F8AB" colspan="2" style="width:77px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$date_sortie.'</nobr></td>
                    <td class="csD149F8AB" colspan="2" style="width:46px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$NombreJour.'</nobr></td>
                    <td class="csD149F8AB" style="width:58px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$prix_unitaire.'$</nobr></td>
                    <td class="csD149F8AB" colspan="2" style="width:71px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$prixTotalSans.'$</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="9" style="width:509px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>R&#233;duction&nbsp;:</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:71px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$reduction.'$</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="9" style="width:509px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;&#224;&nbsp;Payer&nbsp;:</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:71px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalFacture.'$</nobr></td>
                    <td></td>
                  </tr>
                  <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="9" style="width:509px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Reste&nbsp;&#224;&nbsp;Payer&nbsp;:</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:71px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$RestePaie.'$</nobr></td>
                    <td></td>
                  </tr>
                </table>
                </body>
                </html>
                
                ';
        return $output;

    }





        //=============== FACTURE SALLE =====================================================================

        function pdf_facture_salle(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoFactureSalle($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a4');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoFactureSalle($id)
        {
    
                    $titres="BON D'ENTREE CAISSE";

                    $date_ceremonie='';
                    $heure_debut='';
                    $heure_sortie='';
                    $date_reservation='';
                    $prix_unitaire='';
                    $reduction='';
                    $noms='';
                    $sexe='';
                    $contact='';
                    $mail='';
                    $adresse='';
                    $pieceidentite='';
                    $numeroPiece='';
                    $taux='';
                    $CategorieClient='';
                    $nom_salle='';
                    $prix_unitaireReduit='';
                    $totalFacture='';
                    $totalPaie='';
                    $RestePaie='';
                    $codeOperation='';
                    
                    $data = DB::table('thotel_reservation_salle')
                    ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
                    ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
                    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
            
                    ->select('thotel_reservation_salle.id','refClient','refSalle','date_ceremonie','heure_debut',
                    'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','reduction',
                    'observation','thotel_reservation_salle.author','thotel_reservation_salle.created_at',
                    'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
                    'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
                    'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
                    'thotel_reservation_salle.devise','thotel_reservation_salle.taux',
                    'tvente_categorie_client.designation as CategorieClient', 
                    "thotel_salle.designation as nom_salle","thotel_salle.prix_salle")
                    ->selectRaw('CONCAT("RCH",YEAR(thotel_reservation_salle.created_at),"",MONTH(thotel_reservation_salle.created_at),"00",thotel_reservation_salle.id) as codeOperation')
                    ->selectRaw('((prix_unitaire-reduction)/thotel_reservation_salle.taux) as prix_unitaireFC')
                    ->selectRaw('((prix_unitaire-reduction)) as prix_unitaireReduit')
                    ->selectRaw('IFNULL(((prix_unitaire-reduction)),0) as totalFacture')
                    ->selectRaw('IFNULL(paie,0) as totalPaie')
                    ->selectRaw('(IFNULL(((prix_unitaire-reduction)),0)-IFNULL(paie,0)) as RestePaie')
                    ->selectRaw('((IFNULL(((prix_unitaire-reduction)),0)-IFNULL(paie,0))/thotel_reservation_salle.taux) as RestePaieFC')
                    ->where('thotel_reservation_salle.id', $id)
                    ->get();
                    $output='';
                    foreach ($data as $row) 
                    {         
                        $date_ceremonie=$row->date_ceremonie;
                        $heure_debut=$row->heure_debut;
                        $heure_sortie=$row->heure_sortie;
                        $date_reservation=$row->date_reservation;
                        $prix_unitaire=$row->prix_unitaire;
                        $reduction=$row->reduction;
                        $noms=$row->noms;
                        $sexe=$row->sexe;
                        $contact=$row->contact;
                        $mail=$row->mail;
                        $adresse=$row->adresse;
                        $pieceidentite=$row->pieceidentite;
                        $numeroPiece=$row->numeroPiece;
                        $taux=$row->taux;
                        $CategorieClient=$row->CategorieClient;
                        $nom_salle=$row->nom_salle;
                        $prix_unitaireReduit=$row->prix_unitaireReduit;
                        $totalFacture=$row->totalFacture;
                        $totalPaie=$row->totalPaie;
                        $RestePaie=$row->RestePaie;
                        $codeOperation=$row->codeOperation;
                    }
    //ClasseChambre
    
                    //Info Entreprise
                    $nomEse='';
                    $adresseEse='';
                    $Tel1Ese='';
                    $Tel2Ese='';
                    $siteEse='';
                    $emailEse='';
                    $idNatEse='';
                    $numImpotEse='';
                    $rccEse='';
                    $siege='';
                    $busnessName='';
                    $pic='';
                    $pic2 = $this->displayImg("fichier", 'logo.png');
                    $logo='';
            
                    $data1 = DB::table('entreprises')
                    ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
                    ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
            
                    ->join('pays','pays.id','=','entreprises.idPays')
                    ->join('provinces','provinces.id','=','entreprises.idProvince')
                    ->join('users','users.id','=','entreprises.ceo')        
                    ->select('entreprises.id as id','entreprises.id as idEntreprise',
                    'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
                    'entreprises.emailEntreprise','entreprises.adresseEntreprise',
                    'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
                    'entreprises.idforme','entreprises.etat',
                    'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
                    'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                    'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
                    'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
                        //forme
                        'forme_juridiques.nomForme','secteurs.nomSecteur',
                        //users
                        'users.name','users.email','users.avatar','users.telephone','users.adresse',
                        //
                        'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
                    ->get();
                    $output='';
                    foreach ($data1 as $row) 
                    {                                
                        $nomEse=$row->nomEntreprise;
                        $adresseEse=$row->adresseEntreprise;
                        $Tel1Ese=$row->telephoneEntreprise;
                        $Tel2Ese=$row->telephone;
                        $siteEse=$row->siteweb;
                        $emailEse=$row->emailEntreprise;
                        $idNatEse=$row->rccm;
                        $numImpotEse=$row->rccm;
                        $busnessName=$row->nomSecteur;
                        $rccmEse=$row->rccm;
                        $pic = $this->displayImg("fichier", 'logo.png');
                        $siege=$row->nomForme;         
                    }
    
            
                    $output='
    
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                      <title>FactureSalle</title>
                      <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                      <style type="text/css">
                        .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs69040D7 {color:#000000;background-color:transparent;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
                        .cs76F63DEB {color:#000000;background-color:transparent;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                      </style>
                    </head>
                    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:689px;height:411px;position:relative;">
                      <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:70px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:98px;"></td>
                        <td style="height:0px;width:107px;"></td>
                        <td style="height:0px;width:81px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:64px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:77px;"></td>
                        <td style="height:0px;width:92px;"></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csFBB219FE" colspan="9" style="width:499px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.'.$nomEse.'.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="7" style="width:169px;height:154px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:169px;height:154px;">
                          <img alt="" src="'.$pic2.'" style="width:169px;height:154px;" /></div>
                        </td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="9" style="width:499px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="9" style="width:499px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="9" style="width:499px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.'.$adresseEse.'.'</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="9" style="width:499px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="9" style="width:499px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="9" rowspan="2" style="width:499px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs76F63DEB" style="width:66px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Num&nbsp;:</nobr></td>
                        <td class="cs76F63DEB" colspan="6" style="width:358px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$codeOperation.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs69040D7" style="width:66px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Client&nbsp;:</nobr></td>
                        <td class="cs69040D7" colspan="6" style="width:358px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$noms.'&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;'.$contact.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs69040D7" style="width:66px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Res.&nbsp;:</nobr></td>
                        <td class="cs69040D7" colspan="6" style="width:358px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date_reservation.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs8F59FFB2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Salle</nobr></td>
                        <td class="csC73F4F41" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Cer&#233;monie</nobr></td>
                        <td class="csC73F4F41" style="width:106px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;d&#233;but</nobr></td>
                        <td class="csC73F4F41" colspan="2" style="width:103px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;de&nbsp;fin</nobr></td>
                        <td class="csC73F4F41" colspan="4" style="width:164px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;(USD)</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs8F59FFB2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$nom_salle.'</nobr></td>
                        <td class="csD149F8AB" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$date_ceremonie.'</nobr></td>
                        <td class="csD149F8AB" style="width:106px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$heure_debut.'</nobr></td>
                        <td class="csD149F8AB" colspan="2" style="width:103px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$heure_sortie.'</nobr></td>
                        <td class="csC73F4F41" colspan="4" style="width:164px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$prix_unitaire.'$</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs8F59FFB2" colspan="6" style="width:416px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Reduction&nbsp;:</nobr></td>
                        <td class="csC73F4F41" colspan="4" style="width:164px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$reduction.'$</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs8F59FFB2" colspan="6" style="width:416px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;&#224;&nbsp;Payer&nbsp;:</nobr></td>
                        <td class="csC73F4F41" colspan="4" style="width:164px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$prix_unitaireReduit.'$</nobr></td>
                        <td></td>
                      </tr>
                      <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs8F59FFB2" colspan="6" style="width:416px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Reste&nbsp;&#224;&nbsp;Payer&nbsp;:</nobr></td>
                        <td class="csC73F4F41" colspan="4" style="width:164px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$RestePaie.'$</nobr></td>
                        <td></td>
                      </tr>
                    </table>
                    </body>
                    </html>
                    
                    ';
            return $output;
    
        }
    
      


      //=============== FICHE HOTEL =====================================================================

      function pdf_fiche_hotel(Request $request)
      {
  
          if ($request->get('id')) 
          {
              $id = $request->get('id');
              $html = $this->getInfoFicheHotel($id);
              $pdf = \App::make('dompdf.wrapper');
  
              // echo($html);
  
  
              $pdf->loadHTML($html);
              $pdf->loadHTML($html)->setPaper('a4');
              return $pdf->stream();
              
          }
          else{
  
          }
          
          
      }
  
      function getInfoFicheHotel($id)
      {
  
                  $ap="'";
                  $date_entree='';
                  $date_sortie='';
                  $heure_debut='';                
                  $heure_sortie='';
                  $prix_unitaire='';
                  $reduction='';
                  $type_reservation='';
                  $nom_accompagner='';
                  $pays_provenance='';
                  $author='';
                  $noms='';
                  $sexe='';
                  $contact='';
                  $mail='';
                  $adresse='';
                  $pieceidentite='';
                  $numeroPiece='';
                  $dateLivrePiece='';
                  $lieulivraisonCarte='';
                  $nationnalite='';
                  $datenaissance='';
                  $lieunaissance='';
                  $profession='';
                  $occupation='';
                  $nombreEnfant='';
                  $dateArriverGoma='';
                  $arriverPar='';
                  $devise='';
                  $CategorieClient='';
                  $nom_chambre='';
                  $numero_chambre='';
                  $codeOperation='';
                  $prix_unitaireFC='';
                  $NombreJour='';
                  $prixTotalSans='';
                  $prixTotal='';
                  $prixTotalFC='';
                  $totalFacture='';
                  $totalPaie='';
                  $RestePaie='';
                  $RestePaieFC='';
                  $dateReservation='';
                  $ClasseChambre='';
                  $created_at='';
                  
                  $data = DB::table('thotel_reservation_chambre')
                  ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refClient')
                  ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
                  ->join('tvente_client','tvente_client.id','=','thotel_reservation_chambre.refClient')
                  ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
          
                  ->select('thotel_reservation_chambre.id','refClient','refChmabre','date_entree','date_sortie',
                  'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
                  'type_reservation','nom_accompagner','pays_provenance',
                  'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at','noms','sexe',
                  'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
                  'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
                  'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
                  'thotel_reservation_chambre.devise','thotel_reservation_chambre.taux',
                  'tvente_categorie_client.designation as CategorieClient', 
                  "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
                  "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre")
                  ->selectRaw('CONCAT("RCH",YEAR(thotel_reservation_chambre.created_at),"",MONTH(thotel_reservation_chambre.created_at),"00",thotel_reservation_chambre.id) as codeOperation')
                  ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFC')
                  ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
                  ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSans')
                  ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotal')
                  ->selectRaw('((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFC')
                  ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
                  ->selectRaw('IFNULL(paie,0) as totalPaie')
                  ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(paie,0)) as RestePaie')
                  ->selectRaw('((IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(paie,0))/thotel_reservation_chambre.taux) as RestePaieFC')
                  ->where('thotel_reservation_chambre.id', $id)
                  ->get();
                  $output='';
                  foreach ($data as $row) 
                  {         
                      $date_entree=$row->date_entree;
                      $date_sortie=$row->date_sortie;
                      $heure_debut=$row->heure_debut;                
                      $heure_sortie=$row->heure_sortie;
                      $prix_unitaire=$row->prix_unitaire;
                      $reduction=$row->reduction;
                      $type_reservation=$row->type_reservation;
                      $nom_accompagner=$row->nom_accompagner;
                      $pays_provenance=$row->pays_provenance;
                      $author=$row->author;
                      $noms=$row->noms;
                      $sexe=$row->sexe;
                      $contact=$row->contact;
                      $mail=$row->mail;
                      $adresse=$row->adresse;
                      $pieceidentite=$row->pieceidentite;
                      $numeroPiece=$row->numeroPiece;
                      $dateLivrePiece=$row->dateLivrePiece;
                      $lieulivraisonCarte=$row->lieulivraisonCarte;
                      $nationnalite=$row->nationnalite;
                      $datenaissance=$row->datenaissance;
                      $lieunaissance=$row->lieunaissance;
                      $profession=$row->profession;
                      $occupation=$row->occupation;
                      $nombreEnfant=$row->nombreEnfant;
                      $dateArriverGoma=$row->dateArriverGoma;
                      $arriverPar=$row->arriverPar;
                      $devise=$row->devise;
                      $CategorieClient=$row->CategorieClient;
                      $nom_chambre=$row->nom_chambre;
                      $numero_chambre=$row->numero_chambre;
                      $codeOperation=$row->codeOperation;
                      $prix_unitaireFC=$row->prix_unitaireFC;
                      $NombreJour=$row->NombreJour;
                      $prixTotalSans=$row->prixTotalSans;
                      $prixTotal=$row->prixTotal;
                      $prixTotalFC=$row->prixTotalFC;
                      $totalFacture=$row->totalFacture;
                      $totalPaie=$row->totalPaie;
                      $RestePaie=$row->RestePaie;
                      $RestePaieFC=$row->RestePaieFC;
                      $dateReservation=$row->created_at;
                      $ClasseChambre=$row->ClasseChambre;
                      $created_at=$row->created_at;
                      }
  
  
                  //Info Entreprise
                  $nomEse='';
                  $adresseEse='';
                  $Tel1Ese='';
                  $Tel2Ese='';
                  $siteEse='';
                  $emailEse='';
                  $idNatEse='';
                  $numImpotEse='';
                  $rccEse='';
                  $siege='';
                  $busnessName='';
                  $pic='';
                  $pic2 = $this->displayImg("fichier", 'logo.png');
                  $logo='';
          
                  $data1 = DB::table('entreprises')
                  ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
                  ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
          
                  ->join('pays','pays.id','=','entreprises.idPays')
                  ->join('provinces','provinces.id','=','entreprises.idProvince')
                  ->join('users','users.id','=','entreprises.ceo')        
                  ->select('entreprises.id as id','entreprises.id as idEntreprise',
                  'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
                  'entreprises.emailEntreprise','entreprises.adresseEntreprise',
                  'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
                  'entreprises.idforme','entreprises.etat',
                  'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
                  'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                  'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
                  'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
                      //forme
                      'forme_juridiques.nomForme','secteurs.nomSecteur',
                      //users
                      'users.name','users.email','users.avatar','users.telephone','users.adresse',
                      //
                      'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
                  ->get();
                  $output='';
                  foreach ($data1 as $row) 
                  {                                
                      $nomEse=$row->nomEntreprise;
                      $adresseEse=$row->adresseEntreprise;
                      $Tel1Ese=$row->telephoneEntreprise;
                      $Tel2Ese=$row->telephone;
                      $siteEse=$row->siteweb;
                      $emailEse=$row->emailEntreprise;
                      $idNatEse=$row->rccm;
                      $numImpotEse=$row->rccm;
                      $busnessName=$row->nomSecteur;
                      $rccmEse=$row->rccm;
                      $pic = $this->displayImg("fichier", 'logo.png');
                      $siege=$row->nomForme;         
                  }
  
          
                  $output='
  
                  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                  <!-- saved from url=(0016)http://localhost -->
                  <html>
                  <head>
                    <title>FicheHotel</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                      .csE75D3AE5 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .csC3BBD80E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .csD2198692 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .cs37C260D1 {color:#000000;background-color:transparent;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .csE33A3B23 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .cs140EE778 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .csA4A4F90C {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .cs914D1A68 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .cs7384E3C7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .cs5B96C881 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                      .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                      .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                      .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                      .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                      .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                      .cs3AF473BB {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;}
                      .csD4852FAF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; padding-left:2px;}
                      .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                      .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                      .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                  </head>
                  <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                  <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:719px;height:750px;position:relative;">
                    <tr>
                      <td style="width:0px;height:0px;"></td>
                      <td style="height:0px;width:9px;"></td>
                      <td style="height:0px;width:1px;"></td>
                      <td style="height:0px;width:25px;"></td>
                      <td style="height:0px;width:21px;"></td>
                      <td style="height:0px;width:11px;"></td>
                      <td style="height:0px;width:14px;"></td>
                      <td style="height:0px;width:11px;"></td>
                      <td style="height:0px;width:17px;"></td>
                      <td style="height:0px;width:14px;"></td>
                      <td style="height:0px;width:11px;"></td>
                      <td style="height:0px;width:12px;"></td>
                      <td style="height:0px;width:11px;"></td>
                      <td style="height:0px;width:11px;"></td>
                      <td style="height:0px;width:14px;"></td>
                      <td style="height:0px;width:181px;"></td>
                      <td style="height:0px;width:1px;"></td>
                      <td style="height:0px;width:33px;"></td>
                      <td style="height:0px;width:11px;"></td>
                      <td style="height:0px;width:1px;"></td>
                      <td style="height:0px;width:8px;"></td>
                      <td style="height:0px;width:22px;"></td>
                      <td style="height:0px;width:7px;"></td>
                      <td style="height:0px;width:22px;"></td>
                      <td style="height:0px;width:10px;"></td>
                      <td style="height:0px;width:7px;"></td>
                      <td style="height:0px;width:15px;"></td>
                      <td style="height:0px;width:24px;"></td>
                      <td style="height:0px;width:21px;"></td>
                      <td style="height:0px;width:17px;"></td>
                      <td style="height:0px;width:21px;"></td>
                      <td style="height:0px;width:1px;"></td>
                      <td style="height:0px;width:71px;"></td>
                      <td style="height:0px;width:25px;"></td>
                      <td style="height:0px;width:6px;"></td>
                      <td style="height:0px;width:23px;"></td>
                      <td style="height:0px;width:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:23px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:10px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs37C260D1" colspan="8" rowspan="2" style="width:122px;height:94px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:122px;height:94px;">
                        <img alt="" src="'.$pic2.'" style="width:122px;height:94px;" /></div>
                      </td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="cs9E712815" colspan="9" style="width:199px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>NUMERO&nbsp;FICHE&nbsp;:&nbsp;'.$codeOperation.'</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:74px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:5px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:1px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="cs3AF473BB" colspan="18" rowspan="3" style="width:309px;height:45px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Nombre&nbsp;d'.$ap.'enfant&nbsp;de&nbsp;moins&nbsp;de&nbsp;15&nbsp;ans&nbsp;avec</nobr><br/><nobr>Accompagnement&nbsp;du&nbsp;chef&nbsp;de&nbsp;la&nbsp;famille&nbsp;:</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="14" style="width:352px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>FICHE&nbsp;D'.$ap.'INCRIPTION</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="3" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>RCCM&nbsp;:</nobr></td>
                      <td class="cs8A513397" colspan="11" style="width:295px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$rccEse.'</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="3" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>NRC&nbsp;:</nobr></td>
                      <td class="cs8A513397" colspan="11" style="width:295px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$idNatEse.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td class="csD4852FAF" colspan="18" style="width:309px;height:22px;line-height:17px;text-align:left;vertical-align:top;"><nobr>.........'.$nombreEnfant.'..................</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:23px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="3" style="width:55px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>E-mail&nbsp;:</nobr></td>
                      <td class="cs8A513397" colspan="11" style="width:295px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.'.$emailEse.'.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td class="cs3AF473BB" colspan="18" rowspan="3" style="width:309px;height:46px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Number&nbsp;of&nbsp;children&nbsp;under&nbsp;15&nbsp;With&nbsp;the&nbsp;houd&nbsp;the</nobr><br/><nobr>family&nbsp;:&nbsp;......'.$nombreEnfant.'................</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="3" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>T&#233;l&nbsp;:</nobr></td>
                      <td class="cs8A513397" colspan="11" style="width:295px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$Tel1Ese.'</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:1px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="18" style="width:309px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>PIECE&nbsp;D'.$ap.'IDENTITE&nbsp;PRODUITE</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:6px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="18" style="width:309px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Identity&nbsp;documents&nbsp;produced</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:4px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:1px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="6" rowspan="2" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>NATURE&nbsp;:</nobr></td>
                      <td class="cs6105B8F3" colspan="12" rowspan="2" style="width:239px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$pieceidentite.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:21px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="2" rowspan="2" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="12" rowspan="2" style="width:306px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$noms.'</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:1px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:15px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="9" rowspan="3" style="width:134px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Name&nbsp;in&nbsp;capital&nbsp;letter&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="4" rowspan="3" style="width:215px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$noms.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:6px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csE75D3AE5" colspan="2" style="width:8px;height:5px;"></td>
                      <td class="cs140EE778" style="width:22px;height:5px;"></td>
                      <td class="cs140EE778" style="width:7px;height:5px;"></td>
                      <td class="cs140EE778" style="width:22px;height:5px;"></td>
                      <td class="cs140EE778" colspan="3" style="width:32px;height:5px;"></td>
                      <td class="cs140EE778" style="width:24px;height:5px;"></td>
                      <td class="cs140EE778" style="width:21px;height:5px;"></td>
                      <td class="cs140EE778" style="width:17px;height:5px;"></td>
                      <td class="cs140EE778" style="width:21px;height:5px;"></td>
                      <td class="cs140EE778" style="width:1px;height:5px;"></td>
                      <td class="cs140EE778" style="width:71px;height:5px;"></td>
                      <td class="cs140EE778" style="width:25px;height:5px;"></td>
                      <td class="cs140EE778" colspan="2" style="width:29px;height:5px;"></td>
                      <td class="csE33A3B23" style="width:9px;height:5px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:1px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:22px;"></td>
                      <td class="cs8A513397" colspan="12" rowspan="2" style="width:239px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CARTE&nbsp;D'.$ap.'IDENTITE&nbsp;OU&nbsp;PASSEPORT</nobr></td>
                      <td class="cs101A94F7" colspan="2" rowspan="2" style="width:29px;height:22px;"></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:21px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs612ED82F" colspan="12" rowspan="2" style="width:170px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>NOM&nbsp;DE&nbsp;LA&nbsp;JEUNE&nbsp;FILLE&nbsp;:</nobr></td>
                      <td class="csFFC1C457" rowspan="2" style="width:179px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$nom_accompagner.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:1px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:7px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:22px;"></td>
                      <td class="cs8A513397" colspan="9" rowspan="2" style="width:185px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Certicat&nbsp;of&nbsp;Identity&nbsp;or&nbsp;passport</nobr></td>
                      <td class="cs101A94F7" rowspan="2" style="width:25px;height:22px;"></td>
                      <td class="cs101A94F7" colspan="2" rowspan="2" style="width:29px;height:22px;"></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:21px;"></td>
                      <td></td>
                      <td class="cs6105B8F3" colspan="14" rowspan="2" style="width:352px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>.......................................................</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:1px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:7px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:10px;"></td>
                      <td class="cs101A94F7" colspan="3" rowspan="2" style="width:32px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:24px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:21px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:17px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:21px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:1px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:71px;height:10px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:25px;height:10px;"></td>
                      <td class="cs101A94F7" colspan="2" rowspan="2" style="width:29px;height:10px;"></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:9px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="6" rowspan="2" style="width:97px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Maidem&nbsp;names&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="7" rowspan="2" style="width:252px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$nom_accompagner.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:13px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:22px;"></td>
                      <td class="cs8A513397" colspan="2" rowspan="2" style="width:27px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;:</nobr></td>
                      <td class="cs6105B8F3" colspan="13" rowspan="2" style="width:261px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$numeroPiece.'</nobr></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:9px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs6105B8F3" colspan="13" rowspan="2" style="width:351px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>.......................................................</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:13px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:22px;"></td>
                      <td class="cs8A513397" colspan="7" rowspan="2" style="width:105px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DELIVRE&nbsp;LE&nbsp;:</nobr></td>
                      <td class="cs6105B8F3" colspan="8" rowspan="2" style="width:183px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$dateLivrePiece.'</nobr></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:9px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="3" rowspan="2" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>NE&nbsp;LE&nbsp;:</nobr></td>
                      <td class="cs6105B8F3" colspan="10" rowspan="2" style="width:294px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$datenaissance.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:13px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:7px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:22px;"></td>
                      <td class="cs101A94F7" colspan="3" rowspan="2" style="width:32px;height:22px;"></td>
                      <td class="cs8A513397" colspan="3" rowspan="2" style="width:60px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>is&nbsp;dued&nbsp;on</nobr></td>
                      <td class="cs101A94F7" rowspan="2" style="width:21px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:1px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:71px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:25px;height:22px;"></td>
                      <td class="cs101A94F7" colspan="2" rowspan="2" style="width:29px;height:22px;"></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:9px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" rowspan="2" style="width:23px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>A&nbsp;:</nobr></td>
                      <td class="cs6105B8F3" colspan="12" rowspan="2" style="width:326px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$lieunaissance.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:13px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:23px;"></td>
                      <td class="cs8A513397" colspan="2" rowspan="2" style="width:27px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>A&nbsp;:</nobr></td>
                      <td class="cs5B96C881" colspan="6" rowspan="2" style="width:97px;height:23px;line-height:11px;text-align:left;vertical-align:top;"><nobr>'.$lieulivraisonCarte.'</nobr></td>
                      <td class="cs8A513397" colspan="2" rowspan="2" style="width:36px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>PAR&nbsp;:</nobr></td>
                      <td class="cs5B96C881" colspan="5" rowspan="2" style="width:124px;height:23px;line-height:11px;text-align:left;vertical-align:top;"><nobr>CENI</nobr></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:10px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="10" rowspan="2" style="width:145px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;and&nbsp;palce&nbsp;of&nbsp;birth&nbsp;:</nobr></td>
                      <td class="cs6105B8F3" colspan="3" rowspan="2" style="width:204px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>&nbsp;'.$datenaissance.'&nbsp;-&nbsp;'.$lieunaissance.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:13px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:7px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:22px;height:22px;"></td>
                      <td class="cs101A94F7" colspan="3" rowspan="2" style="width:32px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:24px;height:22px;"></td>
                      <td class="cs8A513397" rowspan="2" style="width:19px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>By</nobr></td>
                      <td class="cs101A94F7" rowspan="2" style="width:17px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:21px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:1px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:71px;height:22px;"></td>
                      <td class="cs101A94F7" rowspan="2" style="width:25px;height:22px;"></td>
                      <td class="cs101A94F7" colspan="2" rowspan="2" style="width:29px;height:22px;"></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:9px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="12" rowspan="2" style="width:170px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>PAY&nbsp;POUR&nbsp;L'.$ap.'ETRANGER&nbsp;:</nobr></td>
                      <td class="csFFC1C457" rowspan="2" style="width:179px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$pays_provenance.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:13px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:22px;"></td>
                      <td class="cs8A513397" colspan="10" rowspan="3" style="width:164px;height:32px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DATE&nbsp;D'.$ap.'ENTREE&nbsp;EN&nbsp;RDC</nobr><br/><nobr>:</nobr></td>
                      <td class="cs101A94F7" rowspan="2" style="width:1px;height:22px;"></td>
                      <td class="cs6105B8F3" colspan="4" rowspan="2" style="width:123px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$dateArriverGoma.'</nobr></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:9px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="4" rowspan="3" style="width:69px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Country&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="9" rowspan="3" style="width:280px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$pays_provenance.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:10px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" style="width:8px;height:10px;"></td>
                      <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                      <td class="cs101A94F7" style="width:71px;height:10px;"></td>
                      <td class="cs101A94F7" style="width:25px;height:10px;"></td>
                      <td class="cs101A94F7" colspan="2" style="width:29px;height:10px;"></td>
                      <td class="cs914D1A68" style="width:9px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:3px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csD2198692" colspan="2" rowspan="2" style="width:8px;height:22px;"></td>
                      <td class="cs8A513397" colspan="9" rowspan="2" style="width:143px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;of&nbsp;arrived&nbsp;in&nbsp;DRC&nbsp;:</nobr></td>
                      <td class="cs6105B8F3" colspan="6" rowspan="2" style="width:145px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$dateArriverGoma.'</nobr></td>
                      <td class="cs914D1A68" rowspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:19px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="6" rowspan="2" style="width:97px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>PROFESSION&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="8" rowspan="2" style="width:253px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$profession.'</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:3px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="csC3BBD80E" colspan="2" rowspan="3" style="width:8px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:22px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:7px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:22px;height:33px;"></td>
                      <td class="cs7384E3C7" colspan="3" rowspan="3" style="width:32px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:24px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:21px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:17px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:21px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:1px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:71px;height:33px;"></td>
                      <td class="cs7384E3C7" rowspan="3" style="width:25px;height:33px;"></td>
                      <td class="cs7384E3C7" colspan="2" rowspan="3" style="width:29px;height:33px;"></td>
                      <td class="csA4A4F90C" rowspan="3" style="width:9px;height:33px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="5" style="width:80px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Occupation&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="9" style="width:270px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$occupation.'</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:9px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="11" style="width:156px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DOMICILE&nbsp;HABITUEL&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="3" style="width:194px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$adresse.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="6" style="width:97px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Home&nbsp;adress&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="8" style="width:253px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$adresse.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="7" style="width:111px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>NATIONALITE&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="7" style="width:239px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$nationnalite.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="5" style="width:80px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Nationality&nbsp;:</nobr></td>
                      <td class="csFFC1C457" colspan="9" style="width:270px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$nationnalite.'</nobr></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:19px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:23px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="17" style="width:287px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;:&nbsp;&nbsp;'.$created_at.'</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                      <td style="width:0px;height:22px;"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="cs8A513397" colspan="17" style="width:287px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>SIGNATURE&nbsp;:&nbsp;..................</nobr></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </table>
                  </body>
                  </html>
                  
                  ';
          return $output;
  
      }
  



//==================== RAPPORT JOURNALIER DES CHAMBRES =================================

public function fetch_rapport_hotel_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportHotel($date1, $date2);
       
        $html .='<script>window.print()</script>';

        echo($html); 



        
        // $html = $this->printRapportHotel($date1, $date2);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportHotel($date1, $date2)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }

         
 

         $totalPrice = 0;
         $totalReduc = 0;
         $totalFact = 0;
         $totalSolde = 0;

         $data2 =  DB::table('thotel_reservation_chambre')
         ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refClient')
         ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
         ->join('tvente_client','tvente_client.id','=','thotel_reservation_chambre.refClient')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
 
         ->select(DB::raw('IFNULL(ROUND(SUM((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire)))),0),0) as totalPrices,
         IFNULL(ROUND(SUM(reduction),0),0) as totalReducs,
         IFNULL(ROUND(SUM((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)),0),0) as totalFacts,
         IFNULL(ROUND(SUM((IFNULL(ROUND(SUM((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)),0),0)-IFNULL(paie,0))),0),0) as totalSoldes'))
         ->where([
          ['thotel_reservation_chambre.created_at','>=', $date1],
          ['thotel_reservation_chambre.created_at','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
          $totalPrice=$row->totalPrices;
          $totalReduc=$row->totalReducs;
          $totalFact=$row->totalFacts;
          $totalSolde=$row->totalSoldes;                           
         }
           

        $output='
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
          <title>RapportChambre</title>
          <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
          <style type="text/css">
            .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
            .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
            .cs275E312D {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
            .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
            .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
            .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
            .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
            .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
          </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:1022px;height:321px;position:relative;">
          <tr>
            <td style="width:0px;height:0px;"></td>
            <td style="height:0px;width:10px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:51px;"></td>
            <td style="height:0px;width:62px;"></td>
            <td style="height:0px;width:66px;"></td>
            <td style="height:0px;width:73px;"></td>
            <td style="height:0px;width:146px;"></td>
            <td style="height:0px;width:45px;"></td>
            <td style="height:0px;width:91px;"></td>
            <td style="height:0px;width:87px;"></td>
            <td style="height:0px;width:61px;"></td>
            <td style="height:0px;width:10px;"></td>
            <td style="height:0px;width:45px;"></td>
            <td style="height:0px;width:41px;"></td>
            <td style="height:0px;width:33px;"></td>
            <td style="height:0px;width:49px;"></td>
            <td style="height:0px;width:24px;"></td>
            <td style="height:0px;width:51px;"></td>
            <td style="height:0px;width:11px;"></td>
            <td style="height:0px;width:65px;"></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:23px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:10px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:10px;"></td>
            <td></td>
            <td></td>
            <td class="csFBB219FE" colspan="10" rowspan="2" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:13px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="cs101A94F7" colspan="5" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
              <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
            </td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.'.$adresseEse.'.'</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:21px;"></td>
            <td></td>
            <td></td>
            <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:1px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:15px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:32px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="csB6F858D0" colspan="13" style="width:767px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;RESERVATIONS&nbsp;DES&nbsp;CHAMBRES</nobr></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:14px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="cs275E312D" colspan="2" style="width:50px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Id</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:127px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Classe&nbsp;Chambre</nobr></td>
            <td class="csAB3AA82A" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;Chambre</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:190px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Client</nobr></td>
            <td class="csAB3AA82A" style="width:90px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Entr&#233;e</nobr></td>
            <td class="csAB3AA82A" style="width:86px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Sortie</nobr></td>
            <td class="csAB3AA82A" style="width:60px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Nbr&nbsp;Jours</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:54px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU&nbsp;($)</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT($)</nobr></td>
            <td class="csAB3AA82A" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Reduct.</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:74px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT&nbsp;a&nbsp;Payer</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:75px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Solde</nobr></td>
          </tr>
          ';
        
               $output .= $this->showChambre($date1,$date2); 
        
             $output.='
          <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="cs275E312D" colspan="3" style="width:114px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPrice.'$</nobr></td>
            <td class="csAB3AA82A" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduc.'$</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:74px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:75px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalSolde.'$</nobr></td>
          </tr>
        </table>
        </body>
        </html>
        ';  
       
        return $output; 

}

function showChambre($date1, $date2)
{
    $data = DB::table('thotel_reservation_chambre')
    ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refClient')
    ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
    ->join('tvente_client','tvente_client.id','=','thotel_reservation_chambre.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
   
    ->select('thotel_reservation_chambre.id','refClient','refChmabre','date_entree','date_sortie',
    'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
    'type_reservation','nom_accompagner','pays_provenance',
    'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at','noms','sexe',
    'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
    'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
    'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
    'thotel_reservation_chambre.devise','thotel_reservation_chambre.taux',
    'tvente_categorie_client.designation as CategorieClient', 
    "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
    "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre")
    ->selectRaw('CONCAT("RCH",YEAR(thotel_reservation_chambre.created_at),"",MONTH(thotel_reservation_chambre.created_at),"00",thotel_reservation_chambre.id) as codeOperation')
    ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFC')
    ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
    ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSans')
    ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotal')
    ->selectRaw('((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFC')
    ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
    ->selectRaw('IFNULL(paie,0) as totalPaie')
    ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(paie,0)) as RestePaie')
    ->selectRaw('((IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(paie,0))/thotel_reservation_chambre.taux) as RestePaieFC')
    ->where([
      ['thotel_reservation_chambre.created_at','>=', $date1],
      ['thotel_reservation_chambre.created_at','<=', $date2]
  ])
    ->orderBy("thotel_reservation_chambre.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
      
        $output .='
            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="cs86F8EF7F" colspan="2" style="width:50px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeOperation.'</td>
            <td class="csD06EB5B2" colspan="2" style="width:127px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->ClasseChambre.'</td>
            <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->numero_chambre.'</td>
            <td class="csD06EB5B2" colspan="2" style="width:190px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->noms.'</td>
            <td class="csD06EB5B2" style="width:90px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->date_entree.'</td>
            <td class="csD06EB5B2" style="width:86px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->date_sortie.'</td>
            <td class="csD06EB5B2" style="width:60px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->NombreJour.'</td>
            <td class="csD06EB5B2" colspan="2" style="width:54px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->prix_unitaire.'$</td>
            <td class="csD06EB5B2" colspan="2" style="width:73px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$row->prixTotalSans.'$</nobr></td>
            <td class="csD06EB5B2" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$row->reduction.'$</nobr></td>
            <td class="csD06EB5B2" colspan="2" style="width:74px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
            <td class="csD06EB5B2" colspan="2" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->RestePaie.'$</td>
          </tr>
        ';
 
   
    }

    return $output;

}






//==================== RAPPORT JOURNALIER DES CHAMBRES =================================

public function fetch_rapport_salle_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportSalle($date1, $date2);
       
        $html .='<script>window.print()</script>';

        echo($html); 



        
        // $html = $this->printRapportSalle($date1, $date2);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportSalle($date1, $date2)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 
         $totalFact=0;
         $totalSolde=0;
         // 
         $data2 =  DB::table('thotel_reservation_salle')
         ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
         ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

         ->selectRaw('ROUND(SUM(((prix_unitaire-reduction))),0) as totalFact')
         ->selectRaw('ROUND(SUM((IFNULL(ROUND(SUM(((prix_unitaire-reduction))),0),0)-IFNULL(paie,0))),0) as totalSolde')
         ->where([
            ['thotel_reservation_salle.created_at','>=', $date1],
            ['thotel_reservation_salle.created_at','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->totalFact;
            $totalSolde=$row->totalSolde;               
         }
           

        $output='
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
          <title>RapportSalle</title>
          <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
          <style type="text/css">
            .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
            .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
            .cs275E312D {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
            .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
            .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
            .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
            .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
            .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
          </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:905px;height:321px;position:relative;">
          <tr>
            <td style="width:0px;height:0px;"></td>
            <td style="height:0px;width:10px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:28px;"></td>
            <td style="height:0px;width:12px;"></td>
            <td style="height:0px;width:139px;"></td>
            <td style="height:0px;width:73px;"></td>
            <td style="height:0px;width:146px;"></td>
            <td style="height:0px;width:45px;"></td>
            <td style="height:0px;width:102px;"></td>
            <td style="height:0px;width:76px;"></td>
            <td style="height:0px;width:61px;"></td>
            <td style="height:0px;width:10px;"></td>
            <td style="height:0px;width:33px;"></td>
            <td style="height:0px;width:57px;"></td>
            <td style="height:0px;width:17px;"></td>
            <td style="height:0px;width:95px;"></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:23px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:10px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:23px;"></td>
            <td></td>
            <td></td>
            <td class="csFBB219FE" colspan="10" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
            <td></td>
            <td class="cs101A94F7" colspan="3" rowspan="7" style="width:169px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:169px;height:144px;">
              <img alt="" src="'.$pic2.'" style="width:169px;height:144px;" /></div>
            </td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>$adresseEse</nobr></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td></td>
            <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:11px;"></td>
            <td></td>
            <td></td>
            <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:11px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:15px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:32px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="csB6F858D0" colspan="12" style="width:767px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;RESERVATIONS&nbsp;DES&nbsp;SALLES</nobr></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:14px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="cs275E312D" colspan="3" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Id</nobr></td>
            <td class="csAB3AA82A" style="width:138px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Salle</nobr></td>
            <td class="csAB3AA82A" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DateRes.</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:190px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Client</nobr></td>
            <td class="csAB3AA82A" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Cer&#233;monie</nobr></td>
            <td class="csAB3AA82A" style="width:75px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;d&#233;but</nobr></td>
            <td class="csAB3AA82A" style="width:60px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;fin</nobr></td>
            <td class="csAB3AA82A" colspan="3" style="width:99px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT&nbsp;a&nbsp;Payer</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:111px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Solde</nobr></td>
          </tr>
        ';
                
                       $output .= $this->showSalle($date1,$date2); 
                
                     $output.='
          <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="cs275E312D" colspan="2" style="width:135px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)</nobr></td>
            <td class="csAB3AA82A" colspan="3" style="width:99px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
            <td class="csAB3AA82A" colspan="2" style="width:111px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalSolde.'$</nobr></td>
          </tr>
        </table>
        </body>
        </html>
      ';  
       
        return $output; 

}

function showSalle($date1, $date2)
{
    $data = DB::table('thotel_reservation_salle')
    ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
    ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

    ->select('thotel_reservation_salle.id','refClient','refSalle','date_ceremonie','heure_debut',
    'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','reduction',
    'observation','thotel_reservation_salle.author','thotel_reservation_salle.created_at',
    'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
    'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
    'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
    'thotel_reservation_salle.devise','thotel_reservation_salle.taux',
    'tvente_categorie_client.designation as CategorieClient', 
    "thotel_salle.designation as nom_salle","thotel_salle.prix_salle")
    ->selectRaw('((prix_unitaire-reduction)/thotel_reservation_salle.taux) as prix_unitaireFC')
    ->selectRaw('((prix_unitaire-reduction)) as prix_unitaireReduit')
    ->selectRaw('IFNULL(((prix_unitaire-reduction)),0) as totalFacture')
    ->selectRaw('IFNULL(paie,0) as totalPaie')
    ->selectRaw('(IFNULL(((prix_unitaire-reduction)),0)-IFNULL(paie,0)) as RestePaie')
    ->selectRaw('((IFNULL(((prix_unitaire-reduction)),0)-IFNULL(paie,0))/thotel_reservation_salle.taux) as RestePaieFC')
    ->selectRaw('CONCAT("RS",YEAR(thotel_reservation_salle.created_at),"",MONTH(thotel_reservation_salle.created_at),"00",thotel_reservation_salle.id) as codeOperation')
   
    ->where([
      ['thotel_reservation_salle.created_at','>=', $date1],
      ['thotel_reservation_salle.created_at','<=', $date2]
  ])
    ->orderBy("thotel_reservation_salle.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
      $output .='
            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="cs86F8EF7F" colspan="3" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeOperation.'</td>
            <td class="csD06EB5B2" style="width:138px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->nom_salle.'</td>
            <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->date_reservation.'</td>
            <td class="csD06EB5B2" colspan="2" style="width:190px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->noms.'</td>
            <td class="csD06EB5B2" style="width:101px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->date_ceremonie.'</td>
            <td class="csD06EB5B2" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->heure_debut.'</td>
            <td class="csD06EB5B2" style="width:60px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->heure_sortie.'</td>
            <td class="csD06EB5B2" colspan="3" style="width:99px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->prix_unitaireReduit.'$</td>
            <td class="csD06EB5B2" colspan="2" style="width:111px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->RestePaie.'$</td>
          </tr>
      '; 
   
    }

    return $output;

}










}
