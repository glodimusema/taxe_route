<?php
namespace App\Http\Controllers\Personnel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tTaxeRapportPdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_bon_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoFactureTug($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }
    function getInfoFactureTug($id)
    {

                $Titre="BON D'ENTREE CAISSE ";
                $idDepense='';
                $montant='';
                $montantLettre='';
                $motif='';                
                $dateOperation='';
                $Compte='';
                $refMvt='';
                $author='';
                
                $data = DB::table('tdepense')
                ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
                ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt')        
                ->select("tdepense.id","montant","montantLettre","motif","dateOperation","tdepense.refMvt","refCompte","author",
                "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement","tdepense.created_at","tdepense.updated_at")
                ->where('tdepense.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $idDepense=$row->id;
                    $montant=$row->montant;
                    $montantLettre=$row->montantLettre;
                    $motif=$row->motif;                
                    $dateOperation=$row->dateOperation;
                    $Compte=$row->Compte;
                    $refMvt=$row->refMvt;
                    $author=$row->author;
                
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

                $data1 = DB::table('entreprise') 
                ->join('users' , 'users.id','=','entreprise.ceo')
                ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
                ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
                ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                //MALADE
                ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
                "users.name","users.email as email_user","users.telephone","users.avatar",
                "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
                "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
                "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
                "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
                "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
                "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
                "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
                "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
                "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
                "entreprise.created_at","entreprise.updated_at")->get();
                $output='';
                foreach ($data1 as $row) 
                {                                
                    $nomEse=$row->nom;
                    $adresseEse=$row->adresse;
                    $Tel1Ese=$row->tel1;
                    $Tel2Ese=$row->tel2;
                    $siteEse=$row->siteweb;
                    $emailEse=$row->email;
                    $idNatEse=$row->idnational;
                    $numImpotEse=$row->numImpot;
                    $rccmEse=$row->rccm;
                
                }

        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rpt_BonEntreeCaisse</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5BEF1DA9 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:21px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs366BE10 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs70F3621A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Lucida Calligraphy; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs6CA11120 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:683px;height:481px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:63px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:102px;"></td>
                        <td style="height:0px;width:81px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:29px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:55px;"></td>
                        <td style="height:0px;width:20px;"></td>
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
                        <td class="cs38AECAED" colspan="13" style="width:413px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:36px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs38AECAED" colspan="13" style="width:413px;height:36px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs38AECAED" colspan="13" style="width:413px;height:35px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$Tel1Ese.';'.$Tel2Ese.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$emailEse.',</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:31px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs5BEF1DA9" colspan="13" style="width:413px;height:31px;line-height:24px;text-align:center;vertical-align:middle;"><nobr>'.$Titre.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs5971619E" colspan="21" style="width:676px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs5971619E" colspan="21" style="width:676px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs6CA11120" colspan="8" rowspan="2" style="width:321px;height:33px;line-height:32px;text-align:left;vertical-align:top;"><nobr>'.$Titre.'</nobr></td>
                        <td class="cs70F3621A" colspan="4" rowspan="3" style="width:63px;height:36px;line-height:36px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;:</nobr></td>
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
                        <td class="cs5DE5F832" colspan="2" style="width:109px;height:22px;line-height:18px;text-align:center;vertical-align:top;"><nobr>'.$idDepense.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs366BE10" colspan="6" style="width:113px;height:28px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;:</nobr></td>
                        <td class="csBB9284F7" colspan="5" style="width:153px;height:28px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$montant.'&nbsp;&nbsp;USD</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="cs5971619E" colspan="23" style="width:679px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="cs5971619E" colspan="23" style="width:679px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="5" style="width:237px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>La&nbsp;somme&nbsp;de&nbsp;(en&nbsp;toutes&nbsp;lettres)&nbsp;:</nobr></td>
                        <td class="cs1698ECB3" colspan="12" style="width:342px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$montantLettre.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" style="width:61px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Motif&nbsp;:</nobr></td>
                        <td class="cs1698ECB3" colspan="16" style="width:518px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$motif.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" style="width:61px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Libell&#233;&nbsp;:</nobr></td>
                        <td class="cs1698ECB3" colspan="16" style="width:518px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$Compte.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs5971619E" colspan="22" style="width:677px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5971619E" colspan="22" style="width:677px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="2" style="width:46px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:</nobr></td>
                        <td class="cs1698ECB3" colspan="7" style="width:186px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$dateOperation.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="4" style="width:124px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Pour&nbsp;autorisation</nobr></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" style="width:79px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>La&nbsp;caisse&nbsp;:</nobr></td>
                        <td class="cs9E712815" colspan="4" style="width:97px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$author.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="4" style="width:144px;height:30px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Pour&nbsp;versement</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:36px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs5971619E" colspan="23" style="width:679px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="cs5971619E" colspan="23" style="width:679px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                </table>
                </body>
                </html>';
        return $output;

    }

//==================== RAPPORT JOURNALIER SELON LE COMPTE =================================

public function fetch_rapport_entree_compte_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('refCompte'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refCompte = $request->get('refCompte');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListCompte($date1, $date2,$refCompte);
        $html .= '<script>window.print()</script>';

        echo ($html);          

    }
    else if ($request->get('date1') && $request->get('date2'))
    {
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->printDataList($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        // $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();  
    }
     else {
        // code...
    }
    
}
function printDataListCompte($date1, $date2, $refCompte)
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

         $aps = "'";

         $totalPaie=0;
         $totalQuotite=0;
         $TotalRecouvre=0;
         
         $data2 = DB::table('ttaxe_paiement')   
         ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')     
        ->selectRaw('
            SUM(qte * montant) AS TotalPaie, 
            SUM((qte * montant * quotite) / 100) AS TotalQuotite,
            SUM(recouvrement) AS TotalRecouvre
        ')
        ->whereBetween('dateOperation', [$date1, $date2])
        ->where('refCompte', $refCompte)
        ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie; 
             $totalQuotite=$row->TotalQuotite;
             $TotalRecouvre=$row->TotalRecouvre;               
         }


         $datedebut=$date1;
         $datefin=$date2;
         $agence='';
         $code_agence='';

         $data3 = DB::table('ttaxe_categorie')
        ->join('taxe_unite' , 'taxe_unite.id','=','ttaxe_categorie.id_unite')
        ->select("ttaxe_categorie.id",'designation','prix_categorie','prix_categorie2',
        'id_unite','quotite','nom_unite',"ttaxe_categorie.created_at")       
         ->where([
            ['ttaxe_categorie.id','=', $refCompte]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $agence=$row->designation;
            $code_agence=$row->nom_unite;                   
        }



    

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportTaxe</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1E4BB091 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .csDB0B2364 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs463A9CD7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs5A34C077 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs6AEC9C2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6CA35B49 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Vivaldi; font-size:19px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .cs5682A5DF {color:#228B22;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:901px;height:340px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:41px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:54px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:133px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:122px;"></td>
                    <td style="height:0px;width:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:110px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:110px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" rowspan="2" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:111px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:111px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:111px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MINISTRE&nbsp;DE&nbsp;L'.$aps.'ENVIRONNEMENT&nbsp;ET&nbsp;DEVELOPPEMENT&nbsp;DURABLE</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs6CA35B49" colspan="11" style="width:532px;height:25px;line-height:23px;text-align:center;vertical-align:middle;"><nobr>Le&nbsp;Chef&nbsp;d'.$aps.'Antenne&nbsp;Provinciale&nbsp;a&nbsp;l'.$aps.'interim&nbsp;de&nbsp;la&nbsp;Tshopo&nbsp;et&nbsp;Bas-Uel&#233;</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5682A5DF" colspan="11" style="width:532px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Fonds&nbsp;Forestier&nbsp;National</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5EA817F2" colspan="11" rowspan="3" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.',&nbsp;'.$Tel2Ese.',&nbsp;'.$Tel1Ese.',</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:18px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs2C853136" colspan="13" style="width:597px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS&nbsp;DE&nbsp;LA&nbsp;TAXE</nobr></td>
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
                    <td class="cs5EA817F2" colspan="4" style="width:203px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Du&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
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
                    <td class="cs8BD51C12" colspan="8" style="width:431px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Valeur&nbsp;Filtr&#233;e&nbsp;:&nbsp;'.$agence.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs1E4BB091" style="width:38px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="csEE1F9023" style="width:49px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="csEE1F9023" colspan="5" style="width:188px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Assigetis</nobr></td>
                    <td class="csEE1F9023" colspan="3" style="width:133px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Cat&#233;gorie&nbsp;Taxe</nobr></td>
                    <td class="csEE1F9023" style="width:132px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Exploitation</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;Pay&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:67px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Quotit&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="4" style="width:65px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>&#224;&nbsp;Recouvrer</nobr></td>
                    <td class="csEE1F9023" style="width:121px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Recouvreur</nobr></td>
                    <td></td>
                </tr>
                ';

                        $output .= $this->showDetailPaieCompte($date1,$date2,$refCompte); 

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
                    <td></td>
                    <td class="csDB0B2364" style="width:131px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalQuotite.'FC</nobr></td>
                    <td class="cs5A34C077" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$TotalRecouvre.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" style="width:121px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>
        ';  
       
        return $output; 

}
function showDetailPaieCompte($date1, $date2,$refCompte)
{
    $refMvt=1;
    $data=DB::table('ttaxe_paiement')
    ->join('taxe_exploitation','taxe_exploitation.id','=','ttaxe_paiement.refExploitation')
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
    "tperso_annee.active",'qte','recouvrement','refExploitation','marque_vehicule',
    'lieu_chargement','destination','bordereau','observations','id_unite','quotite',
    'nom_exploitation')
    ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
    ->selectRaw("(qte * montant) as montant_total")
    ->selectRaw("(((qte * montant) * quotite)/100) as montant_quotite")
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2],
        ['ttaxe_paiement.refCompte','=', $refCompte]
    ])    
    ->orderBy("ttaxe_paiement.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {  
    
        $output .='

            	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs463A9CD7" style="width:38px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->id.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:49px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateOperation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="5" style="width:188px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->colProprietaire_Ese.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="3" style="width:133px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->categorietaxe.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:132px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->nom_exploitation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_total.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_quotite.'FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->recouvrement.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" style="width:121px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->noms_agent.'</nobr></td>
                    <td></td>
                </tr>

        ';     
    
    }

    return $output;

}

//======== RAPPORT JOURNALIER GLOBAL ===================================================================================================
//================================================================================================================================================


function printDataList($date1, $date2)
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

         $aps = "'";

         $totalPaie=0;
         $totalQuotite=0;
         $TotalRecouvre=0;
         
         $data2 = DB::table('ttaxe_paiement')  
         ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')      
        ->selectRaw('
            SUM(qte * montant) AS TotalPaie, 
            SUM((qte * montant * quotite) / 100) AS TotalQuotite,
            SUM(recouvrement) AS TotalRecouvre
        ')
        ->whereBetween('dateOperation', [$date1, $date2])
        // ->where('refCompte', $refCompte)
        ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie; 
             $totalQuotite=$row->TotalQuotite;
             $TotalRecouvre=$row->TotalRecouvre;               
         }


         $datedebut=$date1;
         $datefin=$date2;
         $agence='GLOBAL';
         $code_agence='--';

        //  $data3 = DB::table('ttaxe_categorie')
        // ->join('taxe_unite' , 'taxe_unite.id','=','ttaxe_categorie.id_unite')
        // ->select("ttaxe_categorie.id",'designation','prix_categorie','prix_categorie2',
        // 'id_unite','quotite','nom_unite',"ttaxe_categorie.created_at")       
        //  ->where([
        //     ['ttaxe_categorie.id','=', $refCompte]
        // ])      
        // ->get();      
        // $output='';
        // foreach ($data3 as $row) 
        // {
        //     $agence=$row->designation;
        //     $code_agence=$row->nom_unite;                   
        // }



    

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportTaxe</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1E4BB091 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .csDB0B2364 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs463A9CD7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs5A34C077 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs6AEC9C2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6CA35B49 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Vivaldi; font-size:19px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .cs5682A5DF {color:#228B22;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:901px;height:340px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:41px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:54px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:133px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:122px;"></td>
                    <td style="height:0px;width:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:110px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:110px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" rowspan="2" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:111px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:111px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:111px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MINISTRE&nbsp;DE&nbsp;L'.$aps.'ENVIRONNEMENT&nbsp;ET&nbsp;DEVELOPPEMENT&nbsp;DURABLE</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs6CA35B49" colspan="11" style="width:532px;height:25px;line-height:23px;text-align:center;vertical-align:middle;"><nobr>Le&nbsp;Chef&nbsp;d'.$aps.'Antenne&nbsp;Provinciale&nbsp;a&nbsp;l'.$aps.'interim&nbsp;de&nbsp;la&nbsp;Tshopo&nbsp;et&nbsp;Bas-Uel&#233;</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5682A5DF" colspan="11" style="width:532px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Fonds&nbsp;Forestier&nbsp;National</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5EA817F2" colspan="11" rowspan="3" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.',&nbsp;'.$Tel2Ese.',&nbsp;'.$Tel1Ese.',</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:18px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs2C853136" colspan="13" style="width:597px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS&nbsp;DE&nbsp;LA&nbsp;TAXE</nobr></td>
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
                    <td class="cs5EA817F2" colspan="4" style="width:203px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Du&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
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
                    <td class="cs8BD51C12" colspan="8" style="width:431px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Valeur&nbsp;Filtr&#233;e&nbsp;:&nbsp;'.$agence.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs1E4BB091" style="width:38px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="csEE1F9023" style="width:49px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="csEE1F9023" colspan="5" style="width:188px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Assigetis</nobr></td>
                    <td class="csEE1F9023" colspan="3" style="width:133px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Cat&#233;gorie&nbsp;Taxe</nobr></td>
                    <td class="csEE1F9023" style="width:132px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Exploitation</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;Pay&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:67px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Quotit&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="4" style="width:65px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>&#224;&nbsp;Recouvrer</nobr></td>
                    <td class="csEE1F9023" style="width:121px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Recouvreur</nobr></td>
                    <td></td>
                </tr>
                ';

                        $output .= $this->showDetailPaie($date1,$date2); 

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
                    <td></td>
                    <td class="csDB0B2364" style="width:131px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalQuotite.'FC</nobr></td>
                    <td class="cs5A34C077" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$TotalRecouvre.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" style="width:121px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>
        ';  
       
        return $output; 

}
function showDetailPaie($date1, $date2)
{
    $refMvt=1;
    $data=DB::table('ttaxe_paiement')
    ->join('taxe_exploitation','taxe_exploitation.id','=','ttaxe_paiement.refExploitation')
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
    "tperso_annee.active",'qte','recouvrement','refExploitation','marque_vehicule',
    'lieu_chargement','destination','bordereau','observations','id_unite','quotite',
    'nom_exploitation')
    ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
    ->selectRaw("(qte * montant) as montant_total")
    ->selectRaw("(((qte * montant) * quotite)/100) as montant_quotite")
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2]
    ])    
    ->orderBy("ttaxe_paiement.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {  
    
        $output .='

            	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs463A9CD7" style="width:38px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->id.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:49px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateOperation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="5" style="width:188px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->colProprietaire_Ese.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="3" style="width:133px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->categorietaxe.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:132px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->nom_exploitation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_total.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_quotite.'FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->recouvrement.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" style="width:121px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->noms_agent.'</nobr></td>
                    <td></td>
                </tr>

        ';     
    
    }

    return $output;

}


//================== RAPPORT JOURNALIER PAR AGENT ======================================================================
//=======================================================================================================================

public function fetch_rapport_entree_agent_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('refAgent'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refAgent = $request->get('refAgent');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListPaieAgent($date1, $date2,$refAgent);
        $html .= '<script>window.print()</script>';

        echo ($html);

        // $html = $this->printDataListPaieAgent($date1, $date2,$refAgent);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    }
   
    
}
function printDataListAgent($date1, $date2, $refAgent)
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

         $aps = "'";

         $totalPaie=0;
         $totalQuotite=0;
         $TotalRecouvre=0;
         
         $data2 = DB::table('ttaxe_paiement')   
        ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')     
        ->selectRaw('
            SUM(qte * montant) AS TotalPaie, 
            SUM((qte * montant * quotite) / 100) AS TotalQuotite,
            SUM(recouvrement) AS TotalRecouvre
        ')
        ->whereBetween('dateOperation', [$date1, $date2])
        ->where('ttaxe_paiement.refAgent', $refAgent)
        ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie; 
             $totalQuotite=$row->TotalQuotite;
             $TotalRecouvre=$row->TotalRecouvre;               
         }


         $datedebut=$date1;
         $datefin=$date2;
         $agence='';
         $code_agence='';

         $data3 = DB::table('tagent')
        ->select("tagent.id",'matricule_agent','noms_agent',"tagent.created_at")       
         ->where([
            ['tagent.id','=', $refCompte]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $agence=$row->noms_agent;
            $code_agence=$row->matricule_agent;                   
        }



    

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportTaxe</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1E4BB091 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .csDB0B2364 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs463A9CD7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs5A34C077 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs6AEC9C2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6CA35B49 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Vivaldi; font-size:19px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .cs5682A5DF {color:#228B22;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:901px;height:340px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:41px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:54px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:133px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:122px;"></td>
                    <td style="height:0px;width:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:110px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:110px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" rowspan="2" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:111px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:111px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:111px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MINISTRE&nbsp;DE&nbsp;L'.$aps.'ENVIRONNEMENT&nbsp;ET&nbsp;DEVELOPPEMENT&nbsp;DURABLE</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs6CA35B49" colspan="11" style="width:532px;height:25px;line-height:23px;text-align:center;vertical-align:middle;"><nobr>Le&nbsp;Chef&nbsp;d'.$aps.'Antenne&nbsp;Provinciale&nbsp;a&nbsp;l'.$aps.'interim&nbsp;de&nbsp;la&nbsp;Tshopo&nbsp;et&nbsp;Bas-Uel&#233;</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5682A5DF" colspan="11" style="width:532px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Fonds&nbsp;Forestier&nbsp;National</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5EA817F2" colspan="11" rowspan="3" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.',&nbsp;'.$Tel2Ese.',&nbsp;'.$Tel1Ese.',</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:18px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs2C853136" colspan="13" style="width:597px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS&nbsp;DE&nbsp;LA&nbsp;TAXE</nobr></td>
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
                    <td class="cs5EA817F2" colspan="4" style="width:203px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Du&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
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
                    <td class="cs8BD51C12" colspan="8" style="width:431px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Valeur&nbsp;Filtr&#233;e&nbsp;:&nbsp;'.$agence.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs1E4BB091" style="width:38px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="csEE1F9023" style="width:49px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="csEE1F9023" colspan="5" style="width:188px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Assigetis</nobr></td>
                    <td class="csEE1F9023" colspan="3" style="width:133px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Cat&#233;gorie&nbsp;Taxe</nobr></td>
                    <td class="csEE1F9023" style="width:132px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Exploitation</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;Pay&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:67px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Quotit&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="4" style="width:65px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>&#224;&nbsp;Recouvrer</nobr></td>
                    <td class="csEE1F9023" style="width:121px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Recouvreur</nobr></td>
                    <td></td>
                </tr>
                ';

                        $output .= $this->showDetailPaieAgent($date1,$date2,$refAgent); 

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
                    <td></td>
                    <td class="csDB0B2364" style="width:131px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalQuotite.'FC</nobr></td>
                    <td class="cs5A34C077" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$TotalRecouvre.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" style="width:121px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>
        ';  
       
        return $output; 

}
function showDetailPaieAgent($date1, $date2,$refAgent)
{
    $refMvt=1;
    $data=DB::table('ttaxe_paiement')
    ->join('taxe_exploitation','taxe_exploitation.id','=','ttaxe_paiement.refExploitation')
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
    "tperso_annee.active",'qte','recouvrement','refExploitation','marque_vehicule',
    'lieu_chargement','destination','bordereau','observations','id_unite','quotite',
    'nom_exploitation')
    ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
    ->selectRaw("(qte * montant) as montant_total")
    ->selectRaw("(((qte * montant) * quotite)/100) as montant_quotite")
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2],
        ['ttaxe_paiement.refAgent','=', $refAgent]
    ])    
    ->orderBy("ttaxe_paiement.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {  
    
        $output .='

            	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs463A9CD7" style="width:38px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->id.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:49px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateOperation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="5" style="width:188px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->colProprietaire_Ese.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="3" style="width:133px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->categorietaxe.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:132px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->nom_exploitation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_total.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_quotite.'FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->recouvrement.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" style="width:121px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->noms_agent.'</nobr></td>
                    <td></td>
                </tr>

        ';     
    
    }

    return $output;

}
//================== RAPPORT JOURNALIER PAR QUARTIER ======================================================================
//=======================================================================================================================

public function fetch_rapport_entree_quartier_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('ColRefQuartier'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $ColRefQuartier = $request->get('ColRefQuartier');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListPaieQuartier($date1, $date2,$ColRefQuartier);
        $html .= '<script>window.print()</script>';

        echo ($html);          

    }
   
    
}
function printDataListPaieQuartier($date1, $date2,$ColRefQuartier)
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

         $aps = "'";

         $totalPaie=0;
         $totalQuotite=0;
         $TotalRecouvre=0;
         
         $data2 = DB::table('ttaxe_paiement')   
        ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')     
        ->selectRaw('
            SUM(qte * montant) AS TotalPaie, 
            SUM((qte * montant * quotite) / 100) AS TotalQuotite,
            SUM(recouvrement) AS TotalRecouvre
        ')
        ->whereBetween('dateOperation', [$date1, $date2])
        ->where('ColRefQuartier', $ColRefQuartier)
        ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie; 
             $totalQuotite=$row->TotalQuotite;
             $TotalRecouvre=$row->TotalRecouvre;               
         }


         $datedebut=$date1;
         $datefin=$date2;
         $agence='';
         $code_agence='';


        $data3 = DB::table('ttaxe_paiement')
        ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
        ->select('ttaxe_contribuable.colQuartier_Ese','ColRefQuartier')       
        ->whereBetween('dateOperation', [$date1, $date2])
        ->where('ColRefQuartier', $ColRefQuartier)     
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $agence=$row->colQuartier_Ese;
            $code_agence=$row->ColRefQuartier;                   
        }



    

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportTaxe</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1E4BB091 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .csDB0B2364 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs463A9CD7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs5A34C077 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs6AEC9C2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6CA35B49 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Vivaldi; font-size:19px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .cs5682A5DF {color:#228B22;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:901px;height:340px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:41px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:54px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:133px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:122px;"></td>
                    <td style="height:0px;width:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:110px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:110px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" rowspan="2" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:111px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:111px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:111px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MINISTRE&nbsp;DE&nbsp;L'.$aps.'ENVIRONNEMENT&nbsp;ET&nbsp;DEVELOPPEMENT&nbsp;DURABLE</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs6CA35B49" colspan="11" style="width:532px;height:25px;line-height:23px;text-align:center;vertical-align:middle;"><nobr>Le&nbsp;Chef&nbsp;d'.$aps.'Antenne&nbsp;Provinciale&nbsp;a&nbsp;l'.$aps.'interim&nbsp;de&nbsp;la&nbsp;Tshopo&nbsp;et&nbsp;Bas-Uel&#233;</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5682A5DF" colspan="11" style="width:532px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Fonds&nbsp;Forestier&nbsp;National</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5EA817F2" colspan="11" rowspan="3" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.',&nbsp;'.$Tel2Ese.',&nbsp;'.$Tel1Ese.',</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:18px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs2C853136" colspan="13" style="width:597px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS&nbsp;DE&nbsp;LA&nbsp;TAXE</nobr></td>
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
                    <td class="cs5EA817F2" colspan="4" style="width:203px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Du&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
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
                    <td class="cs8BD51C12" colspan="8" style="width:431px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Valeur&nbsp;Filtr&#233;e&nbsp;:&nbsp;'.$agence.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs1E4BB091" style="width:38px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="csEE1F9023" style="width:49px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="csEE1F9023" colspan="5" style="width:188px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Assigetis</nobr></td>
                    <td class="csEE1F9023" colspan="3" style="width:133px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Cat&#233;gorie&nbsp;Taxe</nobr></td>
                    <td class="csEE1F9023" style="width:132px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Exploitation</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;Pay&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:67px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Quotit&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="4" style="width:65px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>&#224;&nbsp;Recouvrer</nobr></td>
                    <td class="csEE1F9023" style="width:121px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Recouvreur</nobr></td>
                    <td></td>
                </tr>
                ';

                        $output .= $this->showDetailPaieQuartier($date1,$date2,$ColRefQuartier); 

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
                    <td></td>
                    <td class="csDB0B2364" style="width:131px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalQuotite.'FC</nobr></td>
                    <td class="cs5A34C077" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$TotalRecouvre.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" style="width:121px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>
        ';  
       
        return $output; 

}
function showDetailPaieQuartier($date1,$date2,$ColRefQuartier)
{
    $refMvt=1;
    $data=DB::table('ttaxe_paiement')
    ->join('taxe_exploitation','taxe_exploitation.id','=','ttaxe_paiement.refExploitation')
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
    "tperso_annee.active",'qte','recouvrement','refExploitation','marque_vehicule',
    'lieu_chargement','destination','bordereau','observations','id_unite','quotite',
    'nom_exploitation')
    ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
    ->selectRaw("(qte * montant) as montant_total")
    ->selectRaw("(((qte * montant) * quotite)/100) as montant_quotite")
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2],
        ['ColRefQuartier','=', $ColRefQuartier]
    ])    
    ->orderBy("ttaxe_paiement.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {  
    
        $output .='

            	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs463A9CD7" style="width:38px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->id.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:49px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateOperation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="5" style="width:188px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->colProprietaire_Ese.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="3" style="width:133px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->categorietaxe.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:132px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->nom_exploitation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_total.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_quotite.'FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->recouvrement.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" style="width:121px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->noms_agent.'</nobr></td>
                    <td></td>
                </tr>

        ';     
    
    }

    return $output;

}
//================== RAPPORT JOURNALIER PAR QUARTIER ======================================================================
//=======================================================================================================================

public function fetch_rapport_entree_ville_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('idVille'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idVille = $request->get('idVille');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListPaieVille($date1, $date2,$idVille);
        $html .= '<script>window.print()</script>';

        echo ($html);

    }
   
    
}

function printDataListPaieVille($date1, $date2,$idVille)
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

         $aps = "'";

         $totalPaie=0;
         $totalQuotite=0;
         $TotalRecouvre=0;
         
         $data2 = DB::table('ttaxe_paiement')   
        ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')  
         ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')     
        ->selectRaw('
            SUM(qte * montant) AS TotalPaie, 
            SUM((qte * montant * quotite) / 100) AS TotalQuotite,
            SUM(recouvrement) AS TotalRecouvre
        ')
        ->whereBetween('dateOperation', [$date1, $date2])
        ->where('idVille', $idVille)
        ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie; 
             $totalQuotite=$row->TotalQuotite;
             $TotalRecouvre=$row->TotalRecouvre;               
         }


         $datedebut=$date1;
         $datefin=$date2;
         $agence='';
         $code_agence='';


        $data3 = DB::table('ttaxe_paiement')
         ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
         ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')  
         ->select('villes.nomVille','communes.idVille')       
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['idVille','=', $idVille]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $agence=$row->nomVille;
            $code_agence=$row->idVille;                   
        }



    

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportTaxe</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1E4BB091 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .csDB0B2364 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs463A9CD7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs5A34C077 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs6AEC9C2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6CA35B49 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Vivaldi; font-size:19px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .cs5682A5DF {color:#228B22;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:901px;height:340px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:41px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:54px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:133px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:122px;"></td>
                    <td style="height:0px;width:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:110px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:110px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" rowspan="2" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:111px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:111px;">
                        <img alt="" src="'.$pic2.'" style="width:131px;height:111px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MINISTRE&nbsp;DE&nbsp;L'.$aps.'ENVIRONNEMENT&nbsp;ET&nbsp;DEVELOPPEMENT&nbsp;DURABLE</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs6CA35B49" colspan="11" style="width:532px;height:25px;line-height:23px;text-align:center;vertical-align:middle;"><nobr>Le&nbsp;Chef&nbsp;d'.$aps.'Antenne&nbsp;Provinciale&nbsp;a&nbsp;l'.$aps.'interim&nbsp;de&nbsp;la&nbsp;Tshopo&nbsp;et&nbsp;Bas-Uel&#233;</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5682A5DF" colspan="11" style="width:532px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Fonds&nbsp;Forestier&nbsp;National</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5EA817F2" colspan="11" rowspan="3" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8BD51C12" colspan="11" style="width:532px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.',&nbsp;'.$Tel2Ese.',&nbsp;'.$Tel1Ese.',</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:18px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs2C853136" colspan="13" style="width:597px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS&nbsp;DE&nbsp;LA&nbsp;TAXE</nobr></td>
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
                    <td class="cs5EA817F2" colspan="4" style="width:203px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Du&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
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
                    <td class="cs8BD51C12" colspan="8" style="width:431px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Valeur&nbsp;Filtr&#233;e&nbsp;:&nbsp;'.$agence.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs1E4BB091" style="width:38px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="csEE1F9023" style="width:49px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="csEE1F9023" colspan="5" style="width:188px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Assigetis</nobr></td>
                    <td class="csEE1F9023" colspan="3" style="width:133px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Cat&#233;gorie&nbsp;Taxe</nobr></td>
                    <td class="csEE1F9023" style="width:132px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Exploitation</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;Pay&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:67px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Quotit&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="4" style="width:65px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>&#224;&nbsp;Recouvrer</nobr></td>
                    <td class="csEE1F9023" style="width:121px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Recouvreur</nobr></td>
                    <td></td>
                </tr>
                ';

                        $output .= $this->showDetailPaieVille($date1,$date2,$idVille); 

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
                    <td></td>
                    <td class="csDB0B2364" style="width:131px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalQuotite.'FC</nobr></td>
                    <td class="cs5A34C077" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$TotalRecouvre.'&nbsp;FC</nobr></td>
                    <td class="cs5A34C077" style="width:121px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>
        ';  
       
        return $output; 

}
function showDetailPaieVille($date1,$date2,$idVille)
{
    $refMvt=1;
    $data = DB::table('ttaxe_paiement')
    ->join('taxe_exploitation','taxe_exploitation.id','=','ttaxe_paiement.refExploitation')
    ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
    ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
    ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
    ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
    ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
    ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
    'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
    "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie','prix_categorie2',
    'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
    'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
    'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
    ,'entreprisePhone1','entreprisePhone2','entrepriseMail','compteur','compteur2','refMois',
    'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee",
    "tperso_annee.active",'qte','recouvrement','refExploitation','marque_vehicule',
    'lieu_chargement','destination','bordereau','observations','id_unite','quotite',
    'nom_exploitation')
    ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
    ->selectRaw("(qte * montant) as montant_total")
    ->selectRaw("(((qte * montant) * quotite)/100) as montant_quotite")
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2],
        ['idVille','=', $idVille]
    ])    
    ->orderBy("ttaxe_paiement.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {  
    
        $output .='

            	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs463A9CD7" style="width:38px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->id.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:49px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateOperation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="5" style="width:188px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->colProprietaire_Ese.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="3" style="width:133px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->categorietaxe.'</nobr></td>
                    <td class="cs6AEC9C2" style="width:132px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->nom_exploitation.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:87px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_total.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_quotite.'FC</nobr></td>
                    <td class="cs6AEC9C2" colspan="4" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->recouvrement.'&nbsp;FC</nobr></td>
                    <td class="cs6AEC9C2" style="width:121px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->noms_agent.'</nobr></td>
                    <td></td>
                </tr>

        ';     
    
    }

    return $output;

}




// =========== NOTE DE PERCEPTION ====================================================================


//=========== NOTE DE PERCEPTION ===================================================================

function pdf_note_perception(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetNotePerception($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}
function GetNotePerception($id)
{           
            $output='';
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
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $bp=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            

            $montant='';
            $montantLettre='';
            $motif='';
            $author='';
            $matricule_agent='';
            $noms_agent='';
            $categorietaxe='';
            $colId_Ese='';
            $colIdNat_Ese='';
            $colRCCM_Ese='';
            $colNom_Ese='';
            $colRaisonSociale_Ese='';
            $colFormeJuridique_Ese='';
            $colGenreActivite_Ese='';
            $ColRefCat='';
            $ColRefQuartier='';
            $colQuartier_Ese='';
            $colAdresseEntreprise_Ese='';
            $colProprietaire_Ese='';
            $colCreatedBy_Ese='';
            $colDateSave_Ese='';
            $current_timestamp='';
            $colStatus='';
            $entreprisePhone1='';
            $entreprisePhone2='';
            $entrepriseMail='';
            $created_at='';
            $dateOperation='';
            $codeRecu='';
            $anneePaie='';
            $codeEntete='';
            // $id='';
            $nomCommune='';

            $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
            $image2 = $this->displayImg("fichier", 'fecoppeme.png');
            $image3 = $this->displayImg("fichier", 'qrcode.png');
            //
            $data2 = DB::table('ttaxe_paiement')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
            ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
            ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
            'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
            "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie',
            'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
            'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
            'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
            ,'entreprisePhone1','entreprisePhone2','entrepriseMail','ttaxe_paiement.created_at','nomCommune') 
            ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
            ->selectRaw('CONCAT("00",ttaxe_paiement.id,"FECOP") as codeEntete')
            ->selectRaw('CONCAT("R",YEAR(ttaxe_paiement.created_at),"",MONTH(ttaxe_paiement.created_at),"00",ttaxe_paiement.id) as codeRecu')
            ->selectRaw('YEAR(ttaxe_paiement.created_at) as anneePaie')
            ->where('ttaxe_paiement.id','=', $id)    
            ->get(); 
            
            foreach ($data2 as $row) 
            {
                // $id=$row->id;
                $montant=$row->montant;
                $montantLettre=$row->montantLettre;
                $motif=$row->motif;
                $author=$row->author;
                $matricule_agent=$row->matricule_agent;
                $noms_agent=$row->noms_agent;
                $categorietaxe=$row->categorietaxe;
                $colId_Ese=$row->colId_Ese;
                $colIdNat_Ese=$row->colIdNat_Ese;
                $colRCCM_Ese=$row->colRCCM_Ese;
                $colNom_Ese=$row->colNom_Ese;
                $colRaisonSociale_Ese=$row->colRaisonSociale_Ese;
                $colFormeJuridique_Ese=$row->colFormeJuridique_Ese;
                $colGenreActivite_Ese=$row->colGenreActivite_Ese;
                $ColRefCat=$row->ColRefCat;
                $ColRefQuartier=$row->ColRefQuartier;
                $colQuartier_Ese=$row->colQuartier_Ese;
                $colAdresseEntreprise_Ese=$row->colAdresseEntreprise_Ese;
                $colProprietaire_Ese=$row->colProprietaire_Ese;
                $colCreatedBy_Ese=$row->colCreatedBy_Ese;
                $colDateSave_Ese=$row->colDateSave_Ese;
                $current_timestamp=$row->current_timestamp;
                $colStatus=$row->colStatus;
                $entreprisePhone1=$row->entreprisePhone1;
                $entreprisePhone2=$row->entreprisePhone2;
                $entrepriseMail=$row->entrepriseMail;
                $created_at=$row->created_at;
                $dateOperation=$row->dateOperation;
                $codeRecu=$row->codeRecu;
                $anneePaie=$row->anneePaie;
                $nomCommune=$row->nomCommune;
                $codeEntete=$row->codeEntete;
            } 
            
            $aps="'";
            
            
            $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>Noteperception</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs6B240DCD {color:#000000;background-color:transparent;border-left:#0000CD 1px solid;border-top:#0000CD 1px solid;border-right:#0000CD 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csB3B827C0 {color:#000000;background-color:transparent;border-left:#0000CD 1px solid;border-top-style: none;border-right:#0000CD 1px solid;border-bottom:#0000CD 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs43EB2CC6 {color:#0000CD;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs4625A9B7 {color:#191970;background-color:transparent;border-left:#0000CD 1px solid;border-top:#0000CD 1px solid;border-right:#0000CD 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csBE62E7CC {color:#191970;background-color:transparent;border-left:#0000CD 1px solid;border-top-style: none;border-right:#0000CD 1px solid;border-bottom:#0000CD 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#98FB98">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:535px;height:396px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:125px;"></td>
                        <td style="height:0px;width:38px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:104px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="11" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="7" style="width:310px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="3" style="width:76px;height:55px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:76px;height:55px;">
                            <img alt="" src="'.$image1.'" style="width:76px;height:55px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="3" style="width:87px;height:54px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:87px;height:54px;">
                            <img alt="" src="'.$image2.'" style="width:87px;height:54px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs38AECAED" colspan="5" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>PROVINCE&nbsp;DE TSHOPO & BAS-UELE</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs38AECAED" colspan="5" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>VILLE&nbsp;DE&nbsp;KISANGANI</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="8" style="width:341px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>FICHE&nbsp;DE&nbsp;ASSUJETTIS&nbsp;ANNUEL&nbsp;DE&nbsp;PME-PMI</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs38AECAED" colspan="10" style="width:393px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;:&nbsp;00'.$codeEntete.'&nbsp;&nbsp;/MGCPTFN12/'.$anneePaie.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="cs38AECAED" colspan="11" style="width:415px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Arret&#233;&nbsp;pronvicial&nbsp;N&#176;01&nbsp;/&nbsp;8/8/CAB/GP-NK/&nbsp;'.$anneePaie.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="cs38AECAED" colspan="11" rowspan="2" style="width:415px;height:33px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Portant&nbsp;approbation&nbsp;des&nbsp;pr&#233;vision&nbsp;budg&#233;taires&nbsp;de&nbsp;la&nbsp;Mairie&nbsp;de&nbsp;Kisangani</nobr><br/><nobr>pour&nbsp;l'.$aps.'exercice&nbsp;'.$anneePaie.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" rowspan="7" style="width:104px;height:101px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:104px;height:101px;">
                            <img alt="" src="'.$image3.'" style="width:104px;height:101px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="4" style="width:120px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Raison&nbsp;Social&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="7" style="width:295px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$colRaisonSociale_Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="4" style="width:120px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Forme&nbsp;juridique&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="7" style="width:295px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$colFormeJuridique_Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="4" style="width:120px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Genre&nbsp;d'.$aps.'activt&#233;s&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="7" style="width:295px;height:15px;line-height:13px;text-align:left;vertical-align:middle;">'.$colGenreActivite_Ese.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="4" style="width:120px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Adresse&nbsp;d'.$aps.'entreprise&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="7" style="width:295px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$colAdresseEntreprise_Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="4" style="width:120px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Propri&#233;taire&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="7" style="width:295px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$colProprietaire_Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="4" rowspan="2" style="width:120px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Commune&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="7" rowspan="2" style="width:295px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$nomCommune.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="6" style="width:187px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;des&nbsp;Comptes&nbsp;Bancaires/TMB&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="5" style="width:228px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr></nobr></td>
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
                        <td class="csA803F7DA" colspan="4" style="width:208px;height:15px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>Fait&nbsp;&#224;&nbsp;Kisangani,&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="5" rowspan="2" style="width:169px;height:17px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;RCCM&nbsp;ou&nbsp;PATENTE</nobr></td>
                        <td class="cs43EB2CC6" colspan="6" style="width:244px;height:15px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>Cette&nbsp;fiche&nbsp;est&nbsp;valable&nbsp;pour&nbsp;l'.$aps.'ann&#233;e&nbsp;'.$anneePaie.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
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
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="5" style="width:169px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;ID.NATIONALE</nobr></td>
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
                        <td class="cs4625A9B7" colspan="5" style="width:165px;height:21px;line-height:16px;text-align:center;vertical-align:top;"><nobr>A&nbsp;payer</nobr></td>
                        <td></td>
                        <td class="cs6B240DCD" colspan="5" style="width:224px;height:21px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBE62E7CC" colspan="5" style="width:165px;height:21px;line-height:16px;text-align:center;vertical-align:top;"><nobr>'.$montant.'&nbsp;FC</nobr></td>
                        <td></td>
                        <td class="csB3B827C0" colspan="5" style="width:224px;height:21px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>            
            '; 

    return $output;

}  

//=========== NOTE DE PERCEPTION ===================================================================

function pdf_fiche_perception(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetFichePerception($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}
function GetFichePerception($id)
{           
            $output='';
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
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $bp=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            

            $montant='';
            $montantLettre='';
            $motif='';
            $author='';
            $matricule_agent='';
            $noms_agent='';
            $categorietaxe='';
            $colId_Ese='';
            $colIdNat_Ese='';
            $colRCCM_Ese='';
            $colNom_Ese='';
            $colRaisonSociale_Ese='';
            $colFormeJuridique_Ese='';
            $colGenreActivite_Ese='';
            $ColRefCat='';
            $ColRefQuartier='';
            $colQuartier_Ese='';
            $colAdresseEntreprise_Ese='';
            $colProprietaire_Ese='';
            $colCreatedBy_Ese='';
            $colDateSave_Ese='';
            $current_timestamp='';
            $colStatus='';
            $entreprisePhone1='';
            $entreprisePhone2='';
            $entrepriseMail='';
            $created_at='';
            $dateOperation='';
            $codeRecu='';
            $anneePaie='';
            $codeEntete='';
            // $id='';
            $nomCommune='';

            $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
            $image2 = $this->displayImg("fichier", 'fecoppeme.png');
            $image3 = $this->displayImg("fichier", 'qrcode.png');
            //
            $data2 = DB::table('ttaxe_paiement')
            ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
            ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
            ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
            ->join('quartiers' , 'quartiers.id','=','ttaxe_contribuable.ColRefQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->select("ttaxe_paiement.id",'montant','montantLettre','motif',
            'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
            "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie',
            'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
            'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
            'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus'
            ,'entreprisePhone1','entreprisePhone2','entrepriseMail','ttaxe_paiement.created_at','nomCommune') 
            ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
            ->selectRaw('CONCAT("00",ttaxe_paiement.id,"FECOP") as codeEntete')
            ->selectRaw('CONCAT("R",YEAR(ttaxe_paiement.created_at),"",MONTH(ttaxe_paiement.created_at),"00",ttaxe_paiement.id) as codeRecu')
            ->selectRaw('YEAR(ttaxe_paiement.created_at) as anneePaie')
            ->where('ttaxe_paiement.id','=', $id)    
            ->get(); 
            
            foreach ($data2 as $row) 
            {
                // $id=$row->id;
                $montant=$row->montant;
                $montantLettre=$row->montantLettre;
                $motif=$row->motif;
                $author=$row->author;
                $matricule_agent=$row->matricule_agent;
                $noms_agent=$row->noms_agent;
                $categorietaxe=$row->categorietaxe;
                $colId_Ese=$row->colId_Ese;
                $colIdNat_Ese=$row->colIdNat_Ese;
                $colRCCM_Ese=$row->colRCCM_Ese;
                $colNom_Ese=$row->colNom_Ese;
                $colRaisonSociale_Ese=$row->colRaisonSociale_Ese;
                $colFormeJuridique_Ese=$row->colFormeJuridique_Ese;
                $colGenreActivite_Ese=$row->colGenreActivite_Ese;
                $ColRefCat=$row->ColRefCat;
                $ColRefQuartier=$row->ColRefQuartier;
                $colQuartier_Ese=$row->colQuartier_Ese;
                $colAdresseEntreprise_Ese=$row->colAdresseEntreprise_Ese;
                $colProprietaire_Ese=$row->colProprietaire_Ese;
                $colCreatedBy_Ese=$row->colCreatedBy_Ese;
                $colDateSave_Ese=$row->colDateSave_Ese;
                $current_timestamp=$row->current_timestamp;
                $colStatus=$row->colStatus;
                $entreprisePhone1=$row->entreprisePhone1;
                $entreprisePhone2=$row->entreprisePhone2;
                $entrepriseMail=$row->entrepriseMail;
                $created_at=$row->created_at;
                $dateOperation=$row->dateOperation;
                $codeRecu=$row->codeRecu;
                $anneePaie=$row->anneePaie;
                $nomCommune=$row->nomCommune;
                $codeEntete=$row->codeEntete;
            } 
            
            $aps="'";
            
            
            $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptFichePaie</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csFE5543F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csC224BBBC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs7FB0B3FE {color:#000000;background-color:transparent;border-left:#0000CD 1px solid;border-top:#0000CD 1px solid;border-right:#0000CD 1px solid;border-bottom:#0000CD 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs9ED68442 {color:#000000;background-color:transparent;border-left:#0000CD 1px solid;border-top:#0000CD 1px solid;border-right:#0000CD 1px solid;border-bottom:#0000CD 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csD4200D41 {color:#000000;background-color:transparent;border-left:#0000CD 1px solid;border-top:#0000CD 1px solid;border-right-style: none;border-bottom:#0000CD 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE9736CB1 {color:#000000;background-color:transparent;border-left:#0000CD 1px solid;border-top-style: none;border-right:#0000CD 1px solid;border-bottom:#0000CD 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA094DDD0 {color:#000000;background-color:transparent;border-left-style: none;border-top:#0000CD 1px solid;border-right:#0000CD 1px solid;border-bottom:#0000CD 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csDFEBE560 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs5B96C881 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5B74C6EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csE152E1D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FAEBD7">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:549px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:29px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:46px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="24" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="3" style="width:62px;height:48px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:62px;height:48px;">
                            <img alt="" src="'.$image1.'" style="width:62px;height:48px;" /></div>
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
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="3" style="width:63px;height:48px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:63px;height:48px;">
                            <img alt="" src="'.$image2.'" style="width:63px;height:48px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csDFEBE560" colspan="8" style="width:129px;height:15px;line-height:11px;text-align:left;vertical-align:top;"><nobr>VILLE DE KISANGANI</nobr></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csDFEBE560" colspan="21" style="width:351px;height:15px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Titre&nbsp;de&nbsp;perception&nbsp;N&#176;&nbsp;3071&nbsp;...00'.$codeEntete.'&nbsp;/MG/FINANCES/&nbsp;'.$dateOperation.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:38px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5B74C6EF" colspan="21" style="width:349px;height:38px;line-height:11px;text-align:center;vertical-align:top;"><nobr>R&#233;f&#233;rence&nbsp;du&nbsp;texte&nbsp;l&#233;gal&nbsp;Ordonnance&nbsp;Loi&nbsp;N&#176;&nbsp;18/004&nbsp;du&nbsp;13&nbsp;mars&nbsp;2018&nbsp;fixant&nbsp;la</nobr><br/><nobr>nomenclature&nbsp;des&nbsp;impots,&nbsp;Droit,&nbsp;Taxes&nbsp;et&nbsp;Redevances&nbsp;de&nbsp;la&nbsp;province&nbsp;et&nbsp;de&nbsp;l'.$aps.'Entit&#233;</nobr><br/><nobr>Territoriale&nbsp;D&#233;centralis&#233;e&nbsp;ainsi&nbsp;que&nbsp;les&nbsp;modalit&#233;s&nbsp;de&nbsp;leur&nbsp;r&#233;partition</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs5971619E" colspan="19" style="width:292px;height:1px;"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="19" style="width:292px;height:1px;"></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csFFC1C457" colspan="6" style="width:120px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Nom&nbsp;ou&nbsp;Raison&nbsp;sociale&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="16" style="width:230px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$colNom_Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="6" style="width:120px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Adresse&nbsp;physique&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="16" style="width:230px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$colAdresseEntreprise_Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csFE5543F" colspan="7" rowspan="2" style="width:130px;height:49px;line-height:11px;text-align:left;vertical-align:top;"><nobr>OBJET</nobr></td>
                        <td class="csFE5543F" colspan="2" style="width:63px;height:28px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Imputation</nobr><br/><nobr>Budg&#233;taire</nobr></td>
                        <td class="csFE5543F" colspan="10" style="width:92px;height:28px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Liquidation</nobr><br/><nobr>d&#233;taill&#233;e</nobr></td>
                        <td class="csFE5543F" colspan="2" style="width:52px;height:28px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Montant</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csFE5543F" colspan="2" style="width:63px;height:19px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Nature</nobr></td>
                        <td class="csFE5543F" colspan="6" style="width:34px;height:19px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Dur&#233;e</nobr></td>
                        <td class="csFE5543F" colspan="4" style="width:54px;height:19px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Taux&nbsp;et&nbsp;Qt&#233;</nobr></td>
                        <td class="csFE5543F" colspan="2" style="width:52px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:60px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csC224BBBC" colspan="7" style="width:130px;height:58px;line-height:11px;text-align:left;vertical-align:top;">'.$colGenreActivite_Ese.'</td>
                        <td class="csC224BBBC" colspan="2" style="width:63px;height:58px;line-height:11px;text-align:left;vertical-align:top;"><nobr>2701228333</nobr></td>
                        <td class="csC224BBBC" colspan="6" style="width:34px;height:58px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Ex</nobr><br/><nobr>'.$anneePaie.'</nobr></td>
                        <td class="csC224BBBC" colspan="4" style="width:54px;height:58px;line-height:11px;text-align:left;vertical-align:top;"><nobr>----</nobr></td>
                        <td class="csC224BBBC" colspan="2" style="width:52px;height:58px;line-height:11px;text-align:left;vertical-align:top;"><nobr>'.$montant.'FC</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csC224BBBC" colspan="11" rowspan="2" style="width:208px;height:14px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>TMB&nbsp;EN&nbsp;USD&nbsp;:&nbsp;00017-28000-23297000201-09</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs5B96C881" colspan="3" style="width:29px;height:14px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>CDF</nobr></td>
                        <td class="cs9ED68442" colspan="4" rowspan="2" style="width:78px;height:14px;line-height:11px;text-align:center;vertical-align:top;"><nobr>'.$montant.'FC</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
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
                        <td class="csC224BBBC" colspan="11" rowspan="2" style="width:208px;height:15px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>TMB&nbsp;EN&nbsp;CDF&nbsp;:&nbsp;00017-28000-23297000201-91</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs5B96C881" colspan="3" style="width:29px;height:15px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>USD</nobr></td>
                        <td class="csE9736CB1" colspan="4" style="width:78px;height:14px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs7FB0B3FE" colspan="21" style="width:349px;height:20px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>En&nbsp;lettre&nbsp;:&nbsp;'.$montantLettre.' francs</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="csD4200D41" colspan="7" style="width:131px;height:31px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>Service&nbsp;d'.$aps.'assiette</nobr></td>
                        <td class="csA094DDD0" colspan="15" style="width:215px;height:31px;line-height:11px;text-align:right;vertical-align:middle;"><nobr>L'.$aps.'Ordonateur</nobr><br/><nobr>Ou&nbsp;son&nbsp;D&#233;l&#233;gu&#233;(e)</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:61px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5B74C6EF" colspan="21" style="width:349px;height:61px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Le&nbsp;payement&nbsp;doit&nbsp;intervenir&nbsp;au&nbsp;plus&nbsp;tard&nbsp;dans&nbsp;le&nbsp;8&nbsp;(huit)&nbsp;jours&nbsp;de&nbsp;la&nbsp;reception&nbsp;et</nobr><br/><nobr>v&#233;rs&#233;&nbsp;&#224;&nbsp;la&nbsp;&lt;&lt;&nbsp;TRUST&nbsp;MERCHANT&nbsp;BANK&nbsp;&gt;&gt;&nbsp;aux&nbsp;comptes&nbsp;ouverts&nbsp;au&nbsp;nom&nbsp;de&nbsp;la</nobr><br/><nobr>&lt;&lt;Ville&nbsp;de&nbsp;Kisangani&gt;&gt;,&nbsp;sous&nbsp;les&nbsp;num&#233;ros&nbsp;supra.&nbsp;D&#233;passant&nbsp;ce&nbsp;d&#233;lai,&nbsp;l'.$aps.'assujetti&nbsp;sera</nobr><br/><nobr>soumis&nbsp;au&nbsp;payment&nbsp;des&nbsp;p&#233;nalit&#233;s.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="10" style="width:200px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date&nbsp;d'.$aps.'ordonnancement&nbsp;:&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="8" style="width:114px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>POUR&nbsp;RECEPTION</nobr></td>
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
                        <td class="csA803F7DA" colspan="5" rowspan="2" style="width:109px;height:15px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>Kisangani,&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="4" rowspan="2" style="width:76px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Le&nbsp;Percepteur</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csFFC1C457" colspan="9" rowspan="2" style="width:158px;height:15px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Nom&nbsp;et&nbsp;signature&nbsp;du&nbsp;percepteur</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs101A94F7" colspan="4" rowspan="3" style="width:68px;height:57px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:68px;height:57px;">
                            <img alt="" src="'.$image3.'" style="width:68px;height:57px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE152E1D" colspan="5" rowspan="2" style="width:109px;height:15px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>Le&nbsp;Receveur</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                </table>
                </body>
                </html>           
            '; 

    return $output;

} 




//================== RAPPORT JOURNALIER PAR AGENT ======================================================================
//=======================================================================================================================

public function fetch_rapport_releve_agent_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('refAgent'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refAgent = $request->get('refAgent');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListReleveAgent($date1, $date2,$refAgent);
        $html .= '<script>window.print()</script>';

        echo ($html);

    }
   
    
}
function printDataListReleveAgent($date1, $date2, $refAgent)
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

        $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
        $image2 = $this->displayImg("fichier", 'fecoppeme.png');
        $image3 = $this->displayImg("fichier", 'qrcode.png');
 
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

         $aps="'";
         $totalPaie=0;
         
         $data2 = DB::table('ttaxe_paiement')        
         ->select(DB::raw('SUM(montant) as TotalPaie'))        
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['refAgent','=', $refAgent]
        ])       
         ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie;                
         }


         $datedebut=$date1;
         $datefin=$date2;
         $noms_agent='';
         $code_agence='';

         $data3=DB::table('ttaxe_paiement')
         ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
         ->select('tagent.noms_agent as noms_agent','refAgent')       
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['refAgent','=', $refAgent]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $noms_agent=$row->noms_agent;
            $code_agence=$row->refAgent;                   
        }



    

        $output='
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rptReleve</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                .csB9948AEE {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                .csAD47C2A9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csE2C087DB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs755F1C83 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csA49D7241 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csAAE7D8C6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs671B350 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csC4190C00 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:440px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:16px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:108px;"></td>
                <td style="height:0px;width:17px;"></td>
                <td style="height:0px;width:40px;"></td>
                <td style="height:0px;width:3px;"></td>
                <td style="height:0px;width:4px;"></td>
                <td style="height:0px;width:183px;"></td>
                <td style="height:0px;width:72px;"></td>
                <td style="height:0px;width:18px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:14px;"></td>
                <td style="height:0px;width:22px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:59px;"></td>
                <td style="height:0px;width:46px;"></td>
                <td style="height:0px;width:9px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
                <td></td>
                <td class="csD24A75E0" colspan="2" style="width:41px;height:6px;"></td>
                <td class="csDDFA3242" style="width:108px;height:6px;"></td>
                <td class="csDDFA3242" style="width:17px;height:6px;"></td>
                <td class="csDDFA3242" colspan="3" style="width:47px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:255px;height:6px;"></td>
                <td class="csDDFA3242" colspan="3" style="width:41px;height:6px;"></td>
                <td class="csDDFA3242" style="width:22px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:109px;height:6px;"></td>
                <td class="cs62ED362D" colspan="2" style="width:52px;height:6px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:41px;height:23px;"></td>
                <td class="cs101A94F7" rowspan="4" style="width:108px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:108px;height:87px;">
                    <img alt="" src="'.$image1.'" style="width:108px;height:87px;" /></div>
                </td>
                <td class="cs101A94F7" style="width:17px;height:23px;"></td>
                <td class="csCE72709D" colspan="8" style="width:341px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                <td class="cs101A94F7" style="width:22px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" rowspan="4" style="width:109px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:109px;height:87px;">
                    <img alt="" src="'.$image2.'" style="width:109px;height:87px;" /></div>
                </td>
                <td class="cs145AAE8A" colspan="2" style="width:52px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:41px;height:22px;"></td>
                <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:47px;height:22px;"></td>
                <td class="cs38AECAED" colspan="2" style="width:251px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>PROVINCE&nbsp;DE TSHOPO & BAS-UELE</nobr></td>
                <td class="cs101A94F7" colspan="3" style="width:41px;height:22px;"></td>
                <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:52px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:41px;height:22px;"></td>
                <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:47px;height:22px;"></td>
                <td class="cs38AECAED" colspan="2" style="width:251px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>VILLE&nbsp;DE&nbsp;KISANGANI</nobr></td>
                <td class="cs101A94F7" colspan="3" style="width:41px;height:22px;"></td>
                <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:52px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:20px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:41px;height:20px;"></td>
                <td class="cs101A94F7" style="width:17px;height:20px;"></td>
                <td class="csCE72709D" colspan="8" rowspan="2" style="width:341px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>'.$nomEse.'</nobr></td>
                <td class="cs101A94F7" style="width:22px;height:20px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:52px;height:20px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:2px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:41px;height:2px;"></td>
                <td class="cs101A94F7" style="width:108px;height:2px;"></td>
                <td class="cs101A94F7" style="width:17px;height:2px;"></td>
                <td class="cs101A94F7" style="width:22px;height:2px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:109px;height:2px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:52px;height:2px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs593B729A" colspan="2" style="width:41px;height:8px;"></td>
                <td class="csE7D235EF" style="width:108px;height:8px;"></td>
                <td class="csE7D235EF" style="width:17px;height:8px;"></td>
                <td class="csE7D235EF" colspan="3" style="width:47px;height:8px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:255px;height:8px;"></td>
                <td class="csE7D235EF" colspan="3" style="width:41px;height:8px;"></td>
                <td class="csE7D235EF" style="width:22px;height:8px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:109px;height:8px;"></td>
                <td class="cs11B2FA6F" colspan="2" style="width:52px;height:8px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:16px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td style="width:0px;height:33px;"></td>
                <td></td>
                <td class="cs7D52592D" colspan="17" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;DE&nbsp;PAIEMENT&nbsp;PAR&nbsp;AGENT</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                <td class="csA49D7241" colspan="15" style="width:673px;height:9px;"></td>
                <td class="cs755F1C83" style="width:6px;height:9px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:22px;"></td>
                <td class="cs12FE94AA" colspan="15" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Periode&#160;:&nbsp;&nbsp;&nbsp;du&nbsp;'.$datedebut.'&nbsp;au&nbsp;'.$datefin.'</nobr></td>
                <td class="cs671B350" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:22px;"></td>
                <td class="cs12FE94AA" colspan="15" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms_agent.'</nobr></td>
                <td class="cs671B350" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs572BC00D" style="width:13px;height:8px;"></td>
                <td class="csC4190C00" colspan="15" style="width:673px;height:8px;"></td>
                <td class="csAAE7D8C6" style="width:6px;height:8px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:3px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="cs58AC6944" colspan="2" style="width:42px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                <td class="cs36E0C1B8" colspan="4" style="width:167px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Assigeties</nobr></td>
                <td class="cs36E0C1B8" colspan="5" style="width:285px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Type&nbsp;d'.$aps.'activit&#233;</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:85px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:113px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;(FC)</nobr></td>
            </tr>
            ';

                    $output .= $this->showDetailReveleAgent($date1,$date2,$refAgent); 

                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs91032837" colspan="14" style="width:582px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;(FC)</nobr></td>
                <td class="cs479D8C74" colspan="3" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'</nobr></td>
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
                <td class="cs12FE94AA" colspan="5" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Kisangani&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs12FE94AA" colspan="7" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;et&nbsp;signature&nbsp;du&nbsp;superviseur</nobr></td>
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
                <td class="cs12FE94AA" colspan="7" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>'.$noms_agent.'</nobr></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}
function showDetailReveleAgent($date1, $date2,$refAgent)
{
    $count=0;
    $refMvt=1;
    $data=DB::table('ttaxe_paiement')
    ->join('ttaxe_contribuable','ttaxe_contribuable.id','=','ttaxe_paiement.refEse')
    ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','ttaxe_paiement.refCompte')
    ->join('tagent' , 'tagent.id','=','ttaxe_paiement.refAgent')
    ->select("ttaxe_paiement.id",'montant','montantLettre','motif','dateOperation',
    'refEse','ttaxe_paiement.refCompte','refAgent','ttaxe_paiement.author',"matricule_agent",
    "noms_agent","sexe_agent",'ttaxe_categorie.designation as categorietaxe','prix_categorie',
    'colId_Ese','colIdNat_Ese','colRCCM_Ese','colNom_Ese','colRaisonSociale_Ese','colFormeJuridique_Ese',
    'colGenreActivite_Ese','ColRefCat','ColRefQuartier','colQuartier_Ese','colAdresseEntreprise_Ese',
    'colProprietaire_Ese','colCreatedBy_Ese','colDateSave_Ese','current_timestamp','colStatus')
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2],
        ['refAgent','=', $refAgent]
    ])    
    ->orderBy("ttaxe_paiement.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $count ++;
        $output .='
            	<tr style="vertical-align:top;">
                <td style="width:0px;height:73px;"></td>
                <td></td>
                <td class="csB9948AEE" colspan="2" style="width:38px;height:71px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csAD47C2A9" colspan="4" style="width:165px;height:71px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->colNom_Ese.'</td>
                <td class="csAD47C2A9" colspan="5" style="width:283px;height:71px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->categorietaxe.'</td>
                <td class="csE2C087DB" colspan="3" style="width:81px;height:71px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateOperation.'</td>
                <td class="csE2C087DB" colspan="3" style="width:109px;height:71px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant.'FC</td>
            </tr>
        '; 
    }

    return $output;

}



//================== RAPPORT JOURNALIER DES ENCODAGES PAR AGENT ======================================================================
//=======================================================================================================================

public function fetch_rapport_encodage_agent_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('nomEncodeur'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $nomEncodeur = $request->get('nomEncodeur');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListEncodageAgent($date1, $date2,$nomEncodeur);
        $html .= '<script>window.print()</script>';

        echo ($html);        

    }
   
    
}
function printDataListEncodageAgent($date1, $date2, $nomEncodeur)
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

         $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
        $image2 = $this->displayImg("fichier", 'fecoppeme.png');
        $image3 = $this->displayImg("fichier", 'qrcode.png');
 
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

         $option_data='';
         $option_categorie='';
 
         $data3=DB::table('ttaxe_encondeur')
         ->select("ttaxe_encondeur.id",'noms','telephone','code_encodeur',
         'password','axe_encodeur',"ttaxe_encondeur.created_at")
         ->where([
            ['ttaxe_encondeur.code_encodeur','=', $nomEncodeur],
        ])      
        ->first();
        if ($data3) 
        {
            $option_data=$data3->noms; 
            $option_categorie=$data3->code_encodeur;             
        }

   

        $output='
       <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>repEncodeur</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB9948AEE {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csAD47C2A9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csE2C087DB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs755F1C83 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csA49D7241 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csAAE7D8C6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs671B350 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csC4190C00 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:438px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:16px;"></td>
                <td style="height:0px;width:25px;"></td>
                <td style="height:0px;width:3px;"></td>
                <td style="height:0px;width:104px;"></td>
                <td style="height:0px;width:18px;"></td>
                <td style="height:0px;width:29px;"></td>
                <td style="height:0px;width:14px;"></td>
                <td style="height:0px;width:3px;"></td>
                <td style="height:0px;width:187px;"></td>
                <td style="height:0px;width:69px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:30px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:78px;"></td>
                <td style="height:0px;width:31px;"></td>
                <td style="height:0px;width:49px;"></td>
                <td style="height:0px;width:9px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
                <td></td>
                <td class="csD24A75E0" colspan="2" style="width:38px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:107px;height:6px;"></td>
                <td class="csDDFA3242" style="width:18px;height:6px;"></td>
                <td class="csDDFA3242" colspan="3" style="width:46px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:256px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:40px;height:6px;"></td>
                <td class="csDDFA3242" style="width:23px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:109px;height:6px;"></td>
                <td class="cs62ED362D" colspan="2" style="width:55px;height:6px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" rowspan="4" style="width:107px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:107px;height:87px;">
                    <img alt="" src="'.$image1.'" style="width:107px;height:87px;" /></div>
                </td>
                <td class="cs101A94F7" style="width:18px;height:23px;"></td>
                <td class="csCE72709D" colspan="7" style="width:340px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                <td class="cs101A94F7" style="width:23px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" rowspan="4" style="width:109px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:109px;height:87px;">
                    <img alt="" src="'.$image2.'" style="width:109px;height:87px;" /></div>
                </td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:22px;"></td>
                <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:46px;height:22px;"></td>
                <td class="cs38AECAED" colspan="2" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>PROVINCE&nbsp;DE TSHOPO & BAS-UELE</nobr></td>
                <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:22px;"></td>
                <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:46px;height:22px;"></td>
                <td class="cs38AECAED" colspan="2" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>VILLE&nbsp;DE&nbsp;KISANGANI</nobr></td>
                <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:20px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:20px;"></td>
                <td class="cs101A94F7" style="width:18px;height:20px;"></td>
                <td class="csCE72709D" colspan="7" rowspan="2" style="width:340px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>'.$nomEse.'</nobr></td>
                <td class="cs101A94F7" style="width:23px;height:20px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:20px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:2px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:2px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:107px;height:2px;"></td>
                <td class="cs101A94F7" style="width:18px;height:2px;"></td>
                <td class="cs101A94F7" style="width:23px;height:2px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:109px;height:2px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:2px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:15px;"></td>
                <td></td>
                <td class="cs593B729A" colspan="2" style="width:38px;height:12px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:107px;height:12px;"></td>
                <td class="csE7D235EF" style="width:18px;height:12px;"></td>
                <td class="csE7D235EF" colspan="3" style="width:46px;height:12px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:256px;height:12px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:40px;height:12px;"></td>
                <td class="csE7D235EF" style="width:23px;height:12px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:109px;height:12px;"></td>
                <td class="cs11B2FA6F" colspan="2" style="width:55px;height:12px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:16px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td style="width:0px;height:33px;"></td>
                <td></td>
                <td class="cs7D52592D" colspan="17" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;DES&nbsp;ASSUJETTIS&nbsp;PAR&nbsp;AGENT</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                <td class="csA49D7241" colspan="15" style="width:673px;height:9px;"></td>
                <td class="cs755F1C83" style="width:6px;height:9px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:22px;"></td>
                <td class="cs12FE94AA" colspan="15" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Periode&#160;:&nbsp;&nbsp;&nbsp;du&nbsp;'.$date1.'&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs671B350" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:22px;"></td>
                <td class="cs12FE94AA" colspan="15" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$option_data.' - '.$option_categorie.'</nobr></td>
                <td class="cs671B350" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs572BC00D" style="width:13px;height:8px;"></td>
                <td class="csC4190C00" colspan="15" style="width:673px;height:8px;"></td>
                <td class="csAAE7D8C6" style="width:6px;height:8px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:3px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="cs58AC6944" colspan="3" style="width:42px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:150px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Assigeties</nobr></td>
                <td class="cs36E0C1B8" colspan="5" style="width:282px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Type&nbsp;Activit&#233;</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:130px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Propri&#233;taire</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
            </tr>
            ';

                            $output .= $this->showDetailEncodageAgent($date1,$date2,$nomEncodeur); 

                            $output.='
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
                <td class="cs12FE94AA" colspan="7" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Kisangani&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs12FE94AA" colspan="6" style="width:218px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;et&nbsp;signature&nbsp;Encodeur</nobr></td>
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
                <td class="cs12FE94AA" colspan="6" style="width:218px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>'.$nomEncodeur.'</nobr></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}
function showDetailEncodageAgent($date1,$date2,$nomEncodeur)
{
    $count=0;
    $refMvt=1;
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
    'author','ttaxe_categorie.designation as categorietaxe','prix_categorie', 
    "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
    "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays",
    "provinces.nomProvince","pays.nomPays",'entreprisePhone1','entreprisePhone2','entrepriseMail'
    ,'ttaxe_contribuable.created_at'
            ,'noms as Encodeur','telephone as TelEncodeur','code_encodeur')
    ->where([
        ['ttaxe_contribuable.created_at','>=', $date1],
        ['ttaxe_contribuable.created_at','<=', $date2],
        ['ttaxe_contribuable.author','=', $nomEncodeur]
    ])    
    ->orderBy("ttaxe_contribuable.colDateSave_Ese", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:90px;"></td>
                <td></td>
                <td class="csB9948AEE" colspan="3" style="width:38px;height:88px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csAD47C2A9" colspan="3" style="width:148px;height:88px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->colNom_Ese.'</td>
                <td class="csAD47C2A9" colspan="5" style="width:280px;height:88px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->categorietaxe.'</td>
                <td class="csE2C087DB" colspan="3" style="width:126px;height:88px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->colProprietaire_Ese.'</td>
                <td class="csE2C087DB" colspan="3" style="width:84px;height:88px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->colDateSave_Ese.'</td>
            </tr>
        ';
    }

    return $output;

}

//================== RAPPORT JOURNALIER PAR AGENT ======================================================================
//=======================================================================================================================

public function fetch_rapport_statistique_quartier_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListStatQuartier($date1, $date2);
        $html .= '<script>window.print()</script>';

        echo ($html);           

    }
   
    
}
function printDataListStatQuartier($date1, $date2)
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

         $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
            $image2 = $this->displayImg("fichier", 'fecoppeme.png');
            $image3 = $this->displayImg("fichier", 'qrcode.png');
        
            $aps="'";
 
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
                <title>rptStatistique</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csB9948AEE {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csAD47C2A9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csE2C087DB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs755F1C83 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csA49D7241 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAAE7D8C6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs671B350 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csC4190C00 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:319px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:107px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:39px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:96px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:34px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:29px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:54px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" colspan="3" style="width:42px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:107px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:18px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:46px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="3" style="width:256px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:40px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:23px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="3" style="width:109px;height:6px;"></td>
                    <td class="cs62ED362D" style="width:51px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" rowspan="4" style="width:107px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:107px;height:87px;">
                        <img alt="" src="'.$image1.'" style="width:107px;height:87px;" /></div>
                    </td>
                    <td class="cs101A94F7" style="width:18px;height:23px;"></td>
                    <td class="csCE72709D" colspan="7" style="width:340px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td class="cs101A94F7" style="width:23px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="3" rowspan="4" style="width:109px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:109px;height:87px;">
                        <img alt="" src="'.$image2.'" style="width:109px;height:87px;" /></div>
                    </td>
                    <td class="cs145AAE8A" style="width:51px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:46px;height:22px;"></td>
                    <td class="cs38AECAED" colspan="3" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>PROVINCE&nbsp;DE TSHOPO & BAS-UELE</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:51px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:46px;height:22px;"></td>
                    <td class="cs38AECAED" colspan="3" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>VILLE&nbsp;DE&nbsp;KISANGANI</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:51px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:18px;height:20px;"></td>
                    <td class="csCE72709D" colspan="7" rowspan="2" style="width:340px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>'.$nomEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:23px;height:20px;"></td>
                    <td class="cs145AAE8A" style="width:51px;height:20px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:107px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:18px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:109px;height:2px;"></td>
                    <td class="cs145AAE8A" style="width:51px;height:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td class="cs593B729A" colspan="3" style="width:42px;height:13px;"></td>
                    <td class="csE7D235EF" style="width:107px;height:13px;"></td>
                    <td class="csE7D235EF" style="width:18px;height:13px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:46px;height:13px;"></td>
                    <td class="csE7D235EF" colspan="3" style="width:256px;height:13px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:40px;height:13px;"></td>
                    <td class="csE7D235EF" style="width:23px;height:13px;"></td>
                    <td class="csE7D235EF" colspan="3" style="width:109px;height:13px;"></td>
                    <td class="cs11B2FA6F" style="width:51px;height:13px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td class="cs7D52592D" colspan="17" style="width:694px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;STATISTIQUE&nbsp;DES&nbsp;RESENCEMENTS</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                    <td class="csA49D7241" colspan="13" style="width:548px;height:9px;"></td>
                    <td class="cs755F1C83" style="width:14px;height:9px;"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8339304C" style="width:13px;height:22px;"></td>
                    <td class="cs12FE94AA" colspan="13" style="width:546px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Periode&#160;:&nbsp;&nbsp;&nbsp;du&nbsp;'.$date1.'&nbsp;au&nbsp;'.$date1.'</nobr></td>
                    <td class="cs671B350" style="width:14px;height:22px;"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:7px;"></td>
                    <td></td>
                    <td class="cs572BC00D" style="width:13px;height:4px;"></td>
                    <td class="csC4190C00" colspan="13" style="width:548px;height:4px;"></td>
                    <td class="csAAE7D8C6" style="width:14px;height:4px;"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs58AC6944" colspan="2" style="width:42px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs36E0C1B8" colspan="6" style="width:258px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Quartier</nobr></td>
                    <td class="cs36E0C1B8" colspan="3" style="width:174px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Nombre</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                ';

                                $output .= $this->showDetailStatQuartier($date1,$date2); 

                                $output.='
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
                    <td class="cs12FE94AA" colspan="6" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Kisangani&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
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
            </table>
            </body>
            </html>
       ';  
       
        return $output; 

}
function showDetailStatQuartier($date1,$date2)
{
    $count=0;
    $refMvt=1;
    $data = DB::table('ttaxe_contribuable')
    ->select(DB::raw('count(*) as quarti_count, colQuartier_Ese'))
    ->where([
        ['ttaxe_contribuable.created_at','>=', $date1],
        ['ttaxe_contribuable.created_at','<=', $date2]
    ])   
    ->groupBy('colQuartier_Ese') 
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:21px;"></td>
                <td></td>
                <td class="csB9948AEE" colspan="2" style="width:38px;height:19px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csAD47C2A9" colspan="6" style="width:256px;height:19px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$row->colQuartier_Ese.'</nobr></td>
                <td class="csE2C087DB" colspan="3" style="width:170px;height:19px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->quarti_count.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        ';
    }

    return $output;

}

//================== RAPPORT JOURNALIER PAR AGENT ======================================================================
//=======================================================================================================================

public function fetch_rapport_statistique_encodeur_date(Request $request)
{
    if ($request->get('date1') && $request->get('date2'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListStatEncodeur($date1, $date2);
        $html .= '<script>window.print()</script>';

        echo ($html);          

    }  
    
}
function printDataListStatEncodeur($date1, $date2)
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

         $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
            $image2 = $this->displayImg("fichier", 'fecoppeme.png');
            $image3 = $this->displayImg("fichier", 'qrcode.png');
        
            $aps="'";
 
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
                <title>rptStatistique</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csB9948AEE {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csAD47C2A9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csE2C087DB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs755F1C83 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csA49D7241 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAAE7D8C6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs671B350 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csC4190C00 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:319px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:107px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:39px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:96px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:34px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:29px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:54px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" colspan="3" style="width:42px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:107px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:18px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:46px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="3" style="width:256px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:40px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:23px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="3" style="width:109px;height:6px;"></td>
                    <td class="cs62ED362D" style="width:51px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" rowspan="4" style="width:107px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:107px;height:87px;">
                        <img alt="" src="'.$image1.'" style="width:107px;height:87px;" /></div>
                    </td>
                    <td class="cs101A94F7" style="width:18px;height:23px;"></td>
                    <td class="csCE72709D" colspan="7" style="width:340px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td class="cs101A94F7" style="width:23px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="3" rowspan="4" style="width:109px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:109px;height:87px;">
                        <img alt="" src="'.$image2.'" style="width:109px;height:87px;" /></div>
                    </td>
                    <td class="cs145AAE8A" style="width:51px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:46px;height:22px;"></td>
                    <td class="cs38AECAED" colspan="3" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>PROVINCE&nbsp;DE TSHOPO & BAS-UELE</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:51px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:46px;height:22px;"></td>
                    <td class="cs38AECAED" colspan="3" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>VILLE&nbsp;DE&nbsp;KISANGANI</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:51px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:18px;height:20px;"></td>
                    <td class="csCE72709D" colspan="7" rowspan="2" style="width:340px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>'.$nomEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:23px;height:20px;"></td>
                    <td class="cs145AAE8A" style="width:51px;height:20px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="3" style="width:42px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:107px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:18px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:109px;height:2px;"></td>
                    <td class="cs145AAE8A" style="width:51px;height:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td class="cs593B729A" colspan="3" style="width:42px;height:13px;"></td>
                    <td class="csE7D235EF" style="width:107px;height:13px;"></td>
                    <td class="csE7D235EF" style="width:18px;height:13px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:46px;height:13px;"></td>
                    <td class="csE7D235EF" colspan="3" style="width:256px;height:13px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:40px;height:13px;"></td>
                    <td class="csE7D235EF" style="width:23px;height:13px;"></td>
                    <td class="csE7D235EF" colspan="3" style="width:109px;height:13px;"></td>
                    <td class="cs11B2FA6F" style="width:51px;height:13px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td class="cs7D52592D" colspan="17" style="width:694px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;STATISTIQUE&nbsp;DES&nbsp;RESENCEMENTS</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                    <td class="csA49D7241" colspan="13" style="width:548px;height:9px;"></td>
                    <td class="cs755F1C83" style="width:14px;height:9px;"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8339304C" style="width:13px;height:22px;"></td>
                    <td class="cs12FE94AA" colspan="13" style="width:546px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Periode&#160;:&nbsp;&nbsp;&nbsp;du&nbsp;'.$date1.'&nbsp;au&nbsp;'.$date1.'</nobr></td>
                    <td class="cs671B350" style="width:14px;height:22px;"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:7px;"></td>
                    <td></td>
                    <td class="cs572BC00D" style="width:13px;height:4px;"></td>
                    <td class="csC4190C00" colspan="13" style="width:548px;height:4px;"></td>
                    <td class="csAAE7D8C6" style="width:14px;height:4px;"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs58AC6944" colspan="2" style="width:42px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs36E0C1B8" colspan="6" style="width:258px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Encodeur</nobr></td>
                    <td class="cs36E0C1B8" colspan="3" style="width:174px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Nombre</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                ';

                                $output .= $this->showDetailStatEncodeur($date1,$date2); 

                                $output.='
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
                    <td class="cs12FE94AA" colspan="6" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Kisangani&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
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
            </table>
            </body>
            </html>
       ';  
       
        return $output; 

}
function showDetailStatEncodeur($date1,$date2)
{
    $count=0;
    $refMvt=1;
    $data = DB::table('ttaxe_contribuable')
    ->leftjoin('ttaxe_encondeur' , 'ttaxe_encondeur.code_encodeur','=','ttaxe_contribuable.author')
    ->select(DB::raw('count(*) as user_count,author,noms'))
    ->where([
        ['ttaxe_contribuable.created_at','>=', $date1],
        ['ttaxe_contribuable.created_at','<=', $date2]
    ])   
    ->groupBy('ttaxe_contribuable.author','ttaxe_encondeur.noms') 
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:21px;"></td>
                <td></td>
                <td class="csB9948AEE" colspan="2" style="width:38px;height:19px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csAD47C2A9" colspan="6" style="width:256px;height:19px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$row->noms.' - '.$row->author.'</nobr></td>
                <td class="csE2C087DB" colspan="3" style="width:170px;height:19px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->user_count.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        ';
    }

    return $output;

}


//==================== RAPPORT JOURNALIER PAR MOIS ET ANNEE =================================


public function fetch_rapport_paiement_mensuel_date(Request $request)
{
    if ($request->get('date1') && $request->get('date2') && $request->get('refMois') && $request->get('refAnnee'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refMois = $request->get('refMois');
        $refAnnee = $request->get('refAnnee');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListMoisAnnee($date1, $date2, $refMois,$refAnnee);
        $html .= '<script>window.print()</script>';

        echo ($html);           

    }  
    
}
function printDataListMoisAnnee($date1, $date2, $refMois,$refAnnee)
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


         $totalPaie=0;
         
         $data2 = DB::table('ttaxe_paiement')        
         ->select(DB::raw('SUM(montant) as TotalPaie'))        
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['refMois','=', $refMois],
            ['refAnnee','=', $refAnnee]
        ])       
         ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie;                
         }


         $datedebut=$date1;
         $datefin=$date2;
         $agence='';
         $code_agence='';

         $data3=DB::table('ttaxe_paiement')
         ->join('tperso_annee' , 'tperso_annee.id','=','ttaxe_paiement.refAnnee')
         ->join('tperso_mois' , 'tperso_mois.id','=','ttaxe_paiement.refMois')
         ->select('refMois',
         'refAnnee','tperso_mois.name_mois',"tperso_annee.name_annee")       
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['refMois','=', $refMois],
            ['refAnnee','=', $refAnnee]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $agence=$row->name_mois;
            $code_agence=$row->name_annee;                   
        }



    

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Depense</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csE14C81B5 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs18C8C797 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .csAFF8CC7 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .cs92CE5FDD {color:#FF0000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:916px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:6px;"></td>
                <td style="height:0px;width:68px;"></td>
                <td style="height:0px;width:45px;"></td>
                <td style="height:0px;width:31px;"></td>
                <td style="height:0px;width:13px;"></td>
                <td style="height:0px;width:12px;"></td>
                <td style="height:0px;width:34px;"></td>
                <td style="height:0px;width:59px;"></td>
                <td style="height:0px;width:131px;"></td>
                <td style="height:0px;width:59px;"></td>
                <td style="height:0px;width:98px;"></td>
                <td style="height:0px;width:177px;"></td>
                <td style="height:0px;width:20px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:37px;"></td>
                <td style="height:0px;width:25px;"></td>
                <td style="height:0px;width:73px;"></td>
                <td style="height:0px;width:8px;"></td>
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
                <td style="width:0px;height:16px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic.'" style="width:144px;height:128px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic.'" style="width:144px;height:128px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
                <td class="csA67C9637" colspan="7" style="width:566px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="4" style="width:145px;height:92px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:92px;">
                    <img alt="" src="'.$pic2.'" style="width:145px;height:92px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs92CE5FDD" colspan="7" style="width:566px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>&quot;'.$nomEse.'&quot;</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:25px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csAFF8CC7" colspan="7" style="width:566px;height:25px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>Si&#232;ge&nbsp;Sociale&nbsp;et&nbsp;Administratif&nbsp;&#224;&nbsp;'.$siege.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:21px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs5DE5F832" colspan="7" style="width:566px;height:21px;line-height:18px;text-align:center;vertical-align:middle;">Adresse&nbsp;:'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:25px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csECF45065" colspan="7" style="width:566px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csECF45065" colspan="7" rowspan="2" style="width:566px;height:24px;line-height:16px;text-align:center;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="13" style="width:702px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;RECETTES&nbsp;A&nbsp;LA&nbsp;CAISSE</nobr></td>
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
                <td class="cs56F73198" colspan="7" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="csE14C81B5" style="width:95px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>SECTEUR&nbsp;:</nobr></td>
                <td class="cs18C8C797" colspan="4" style="width:241px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$agence.' - '.$code_agence.'</nobr></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="2" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;BS</nobr></td>
                <td class="cs9FE9304F" colspan="4" style="width:100px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;(FC)</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:287px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Contribuable</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:206px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE TAXE</nobr></td>
                <td class="csEAC52FCD" colspan="4" style="width:143px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Recouvreur(E)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailPaieMoisAnnee($date1,$date2,$refMois,$refAnnee); 

            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="2" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL(FC)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="16" style="width:832px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'FC</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="7" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Kisangani&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}
function showDetailPaieMoisAnnee($date1,$date2,$refMois,$refAnnee)
{
    $refMvt=1;
    $data=DB::table('ttaxe_paiement')
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
    "tperso_annee.active","dateOperation")
    // ->selectRaw("DATE_FORMAT(dateOperation,'%d/%M/%Y') as dateOperation")
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2],
        ['refMois','=', $refMois],
        ['refAnnee','=', $refAnnee]
    ])    
    ->orderBy("ttaxe_paiement.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {  
    
        $output.='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" colspan="2" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">00'.$row->id.'</td>
        <td class="cs6E02D7D2" colspan="4" style="width:100px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant.'FC</td>
        <td class="cs6E02D7D2" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateOperation.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:287px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->colProprietaire_Ese.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:206px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->categorietaxe.'</td>
        <td class="cs6C28398D" colspan="4" style="width:143px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
    </tr>';       
    
    }

    return $output;

}




//================== RAPPORT JOURNALIER DES ENCODAGES PAR AGENT ======================================================================
//=======================================================================================================================

public function fetch_rapport_encodage_quartier_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('colQuartier_Ese'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $colQuartier_Ese = $request->get('colQuartier_Ese');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListEncodageQuartier($date1, $date2,$colQuartier_Ese);
        $html .= '<script>window.print()</script>';

        echo ($html);        

    }
   
    
}
function printDataListEncodageQuartier($date1, $date2,$colQuartier_Ese)
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

         $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
        $image2 = $this->displayImg("fichier", 'fecoppeme.png');
        $image3 = $this->displayImg("fichier", 'qrcode.png');
 
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

         $option_data='';
         $option_categorie='';
 
         $data3=DB::table('quartiers')
         ->select("quartiers.id",'idCommune', 'nomQuartier','codeQuartier')
         ->where([
            ['quartiers.nomQuartier','=', $colQuartier_Ese],
        ])      
        ->first();
        if ($data3) 
        {
            $option_data=$data3->nomQuartier; 
            $option_categorie=$data3->codeQuartier;             
        }

   

        $output='
       <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>repEncodeur</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB9948AEE {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csAD47C2A9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csE2C087DB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs755F1C83 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csA49D7241 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csAAE7D8C6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs671B350 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csC4190C00 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:438px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:16px;"></td>
                <td style="height:0px;width:25px;"></td>
                <td style="height:0px;width:3px;"></td>
                <td style="height:0px;width:104px;"></td>
                <td style="height:0px;width:18px;"></td>
                <td style="height:0px;width:29px;"></td>
                <td style="height:0px;width:14px;"></td>
                <td style="height:0px;width:3px;"></td>
                <td style="height:0px;width:187px;"></td>
                <td style="height:0px;width:69px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:30px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:78px;"></td>
                <td style="height:0px;width:31px;"></td>
                <td style="height:0px;width:49px;"></td>
                <td style="height:0px;width:9px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
                <td></td>
                <td class="csD24A75E0" colspan="2" style="width:38px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:107px;height:6px;"></td>
                <td class="csDDFA3242" style="width:18px;height:6px;"></td>
                <td class="csDDFA3242" colspan="3" style="width:46px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:256px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:40px;height:6px;"></td>
                <td class="csDDFA3242" style="width:23px;height:6px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:109px;height:6px;"></td>
                <td class="cs62ED362D" colspan="2" style="width:55px;height:6px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" rowspan="4" style="width:107px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:107px;height:87px;">
                    <img alt="" src="'.$image1.'" style="width:107px;height:87px;" /></div>
                </td>
                <td class="cs101A94F7" style="width:18px;height:23px;"></td>
                <td class="csCE72709D" colspan="7" style="width:340px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>REPUBLIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                <td class="cs101A94F7" style="width:23px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" rowspan="4" style="width:109px;height:87px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:109px;height:87px;">
                    <img alt="" src="'.$image2.'" style="width:109px;height:87px;" /></div>
                </td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:22px;"></td>
                <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:46px;height:22px;"></td>
                <td class="cs38AECAED" colspan="2" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>PROVINCE&nbsp;DE TSHOPO & BAS-UELE</nobr></td>
                <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:22px;"></td>
                <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:46px;height:22px;"></td>
                <td class="cs38AECAED" colspan="2" style="width:252px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>VILLE&nbsp;DE&nbsp;KISANGANI</nobr></td>
                <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:20px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:20px;"></td>
                <td class="cs101A94F7" style="width:18px;height:20px;"></td>
                <td class="csCE72709D" colspan="7" rowspan="2" style="width:340px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>'.$nomEse.'</nobr></td>
                <td class="cs101A94F7" style="width:23px;height:20px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:20px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:2px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:38px;height:2px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:107px;height:2px;"></td>
                <td class="cs101A94F7" style="width:18px;height:2px;"></td>
                <td class="cs101A94F7" style="width:23px;height:2px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:109px;height:2px;"></td>
                <td class="cs145AAE8A" colspan="2" style="width:55px;height:2px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:15px;"></td>
                <td></td>
                <td class="cs593B729A" colspan="2" style="width:38px;height:12px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:107px;height:12px;"></td>
                <td class="csE7D235EF" style="width:18px;height:12px;"></td>
                <td class="csE7D235EF" colspan="3" style="width:46px;height:12px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:256px;height:12px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:40px;height:12px;"></td>
                <td class="csE7D235EF" style="width:23px;height:12px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:109px;height:12px;"></td>
                <td class="cs11B2FA6F" colspan="2" style="width:55px;height:12px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:16px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td style="width:0px;height:33px;"></td>
                <td></td>
                <td class="cs7D52592D" colspan="17" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;DES&nbsp;ASSUJETTIS&nbsp;PAR&nbsp;AGENT</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                <td class="csA49D7241" colspan="15" style="width:673px;height:9px;"></td>
                <td class="cs755F1C83" style="width:6px;height:9px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:22px;"></td>
                <td class="cs12FE94AA" colspan="15" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Periode&#160;:&nbsp;&nbsp;&nbsp;du&nbsp;'.$date1.'&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs671B350" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:22px;"></td>
                <td class="cs12FE94AA" colspan="15" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$option_data.' - '.$option_categorie.'</nobr></td>
                <td class="cs671B350" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs572BC00D" style="width:13px;height:8px;"></td>
                <td class="csC4190C00" colspan="15" style="width:673px;height:8px;"></td>
                <td class="csAAE7D8C6" style="width:6px;height:8px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:3px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="cs58AC6944" colspan="3" style="width:42px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:150px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Assigeties</nobr></td>
                <td class="cs36E0C1B8" colspan="5" style="width:282px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Type&nbsp;Activit&#233;</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:130px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Propri&#233;taire</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
            </tr>
            ';

                            $output .= $this->showDetailEncodageQuartier($date1,$date2,$colQuartier_Ese); 

                            $output.='
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
                <td class="cs12FE94AA" colspan="7" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Kisangani&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs12FE94AA" colspan="6" style="width:218px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;et&nbsp;signature&nbsp;Encodeur</nobr></td>
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
                <td class="cs12FE94AA" colspan="6" style="width:218px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>'.$option_data.'</nobr></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}
function showDetailEncodageQuartier($date1,$date2,$colQuartier_Ese)
{
    $count=0;
    $refMvt=1;
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
    'author','ttaxe_categorie.designation as categorietaxe','prix_categorie', 
    "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
    "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays",
    "provinces.nomProvince","pays.nomPays",'entreprisePhone1','entreprisePhone2','entrepriseMail'
    ,'ttaxe_contribuable.created_at'
            ,'noms as Encodeur','telephone as TelEncodeur','code_encodeur')
    ->where([
        ['ttaxe_contribuable.created_at','>=', $date1],
        ['ttaxe_contribuable.created_at','<=', $date2],
        ['ttaxe_contribuable.colQuartier_Ese','=', $colQuartier_Ese]
    ])    
    ->orderBy("ttaxe_contribuable.colDateSave_Ese", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:90px;"></td>
                <td></td>
                <td class="csB9948AEE" colspan="3" style="width:38px;height:88px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csAD47C2A9" colspan="3" style="width:148px;height:88px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->colNom_Ese.':('.$row->id.')</td>
                <td class="csAD47C2A9" colspan="5" style="width:280px;height:88px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->categorietaxe.'</td>
                <td class="csE2C087DB" colspan="3" style="width:126px;height:88px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->colProprietaire_Ese.'</td>
                <td class="csE2C087DB" colspan="3" style="width:84px;height:88px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->colDateSave_Ese.'</td>
            </tr>
        ';
    }

    return $output;

}



//================== RAPPORT CARTE DES MEMBRES ======================================================================
//=======================================================================================================================

public function fetch_carte_membre(Request $request)
{
    if ($request->get('id'))  {

        $id = $request->get('id');
            $html = $this->printDataCarteMembre($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a6');
            return $pdf->stream();

      

    }  
    
}
function printDataCarteMembre($id)
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

         $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
         $image2 = $this->displayImg("fichier", 'fecoppeme.png');
         $image3 = $this->displayImg("fichier", 'qrcode.png');
        
         $aps="'";
 
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


         $colNom_Ese='';
         $colAdresseEntreprise_Ese='';
         $colCreatedBy_Ese='';
         $codeCarte='';
 
         $data3=DB::table('ttaxe_detail_profession')
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
         ->selectRaw('CONCAT("C",YEAR(ttaxe_detail_profession.created_at),"",MONTH(ttaxe_detail_profession.created_at),"00",ttaxe_detail_profession.id) as codeCarte')
         ->where([
            ['ttaxe_detail_profession.id','=', $id],
        ])      
        ->first();
        if ($data3) 
        {
            $colNom_Ese=$data3->colNom_Ese;
            $colAdresseEntreprise_Ese=$data3->colAdresseEntreprise_Ese;
            $colCreatedBy_Ese=$data3->colCreatedBy_Ese;
            $codeCarte=$data3->codeCarte;          
        }
   

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptCarteMembre</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csA7CB06AF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csAAA9B5FF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs70CD0380 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:212px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:25px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:129px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:101px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="11" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csAAA9B5FF" colspan="8" style="width:292px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>REPULIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="4" rowspan="3" style="width:64px;height:52px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:64px;height:52px;">
                        <img alt="" src="'.$image1.'" style="width:64px;height:52px;" /><!--[if lt IE 7]></div><![endif]--></div>
                    </td>
                    <td class="csAAA9B5FF" colspan="3" style="width:165px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>VILLE&nbsp;DE&nbsp;KISANGANI</nobr></td>
                    <td class="cs101A94F7" rowspan="3" style="width:63px;height:52px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:63px;height:52px;">
                        <img alt="" src="'.$image2.'" style="width:63px;height:52px;" /><!--[if lt IE 7]></div><![endif]--></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csAAA9B5FF" colspan="3" style="width:165px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>VILLE DE KISANGANI</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:15px;"></td>
                    <td></td>
                    <td class="cs70CD0380" colspan="2" style="width:24px;height:15px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>ID&nbsp;:</nobr></td>
                    <td class="csA7CB06AF" colspan="4" style="width:166px;height:15px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>'.$codeCarte.'</nobr></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="4" style="width:93px;height:77px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:93px;height:77px;">
                        <img alt="" src="'.$image3.'" style="width:93px;height:77px;" /><!--[if lt IE 7]></div><![endif]--></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs70CD0380" colspan="3" style="width:35px;height:22px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>Noms&nbsp;:</nobr></td>
                    <td class="csA7CB06AF" colspan="3" style="width:155px;height:22px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>'.$colNom_Ese.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs70CD0380" colspan="4" style="width:49px;height:22px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>Adresse&nbsp;:</nobr></td>
                    <td class="csA7CB06AF" colspan="2" style="width:141px;height:22px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>'.$colAdresseEntreprise_Ese.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:18px;"></td>
                    <td></td>
                    <td class="cs70CD0380" colspan="2" rowspan="2" style="width:24px;height:20px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&nbsp;:</nobr></td>
                    <td class="csA7CB06AF" colspan="4" rowspan="2" style="width:166px;height:20px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>'.$colCreatedBy_Ese.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csAAA9B5FF" colspan="8" style="width:292px;height:14px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Carte&nbsp;des&nbsp;membres&nbsp;vendeurs&nbsp;de&nbsp;sable</nobr></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>
       ';  
       
        return $output; 

}

//================== RAPPORT JOURNALIER DES ENCODAGES PAR AGENT ======================================================================
//=======================================================================================================================

public function fetch_rapport_liste_membres_profession(Request $request)
{
    //

    if ($request->get('id_profession'))  {
        // code...
        $id_profession = $request->get('id_profession');

        $html = "";
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListMembreProfession($id_profession);
        $html .= '<script>window.print()</script>';

        echo ($html);        

    }
   
    
}
function printDataListMembreProfession($id_profession)
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

         $image1 = $this->displayImg("fichier", 'fecoppeme1.png');
        $image2 = $this->displayImg("fichier", 'fecoppeme.png');
        $image3 = $this->displayImg("fichier", 'qrcode.png');
 
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
                <title>rptVendeurSable</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1E4BB091 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs463A9CD7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs6AEC9C2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csAAA9B5FF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:664px;height:248px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:48px;"></td>
                    <td style="height:0px;width:64px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:74px;"></td>
                    <td style="height:0px;width:123px;"></td>
                    <td style="height:0px;width:62px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:15px;"></td>
                    <td style="height:0px;width:61px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:3px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:13px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="5" style="width:112px;height:107px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:112px;height:107px;">
                        <img alt="" src="'.$image1.'" style="width:112px;height:107px;" /><!--[if lt IE 7]></div><![endif]--></div>
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
                    <td class="cs101A94F7" colspan="2" rowspan="5" style="width:112px;height:107px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:112px;height:107px;">
                        <img alt="" src="'.$image2.'" style="width:112px;height:107px;" /><!--[if lt IE 7]></div><![endif]--></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csAAA9B5FF" colspan="7" style="width:385px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>REPULIQUE&nbsp;DEMOCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csAAA9B5FF" colspan="4" style="width:243px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>VILLE&nbsp;DE&nbsp;KISANGANI</nobr></td>
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
                    <td class="csAAA9B5FF" colspan="4" style="width:243px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>VILLE DE KISANGANI</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:28px;"></td>
                    <td></td>
                    <td></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs2C853136" colspan="12" style="width:584px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>LISTE&nbsp;DES&nbsp;MEMBRES</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs1E4BB091" style="width:46px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="csEE1F9023" colspan="3" style="width:91px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Code</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:196px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Nom</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:108px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Secteur</nobr></td>
                    <td class="csEE1F9023" colspan="4" style="width:141px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Profession</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:65px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Contact</nobr></td>
                </tr>
                ';

                                        $output .= $this->showDetailMembreProfession($id_profession); 

                                        $output.='
            </table>
            </body>
            </html>
        ';

       
        return $output; 

}
function showDetailMembreProfession($id_profession)
{
    $count=0;
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
    ->selectRaw('CONCAT("C",YEAR(ttaxe_detail_profession.created_at),"",MONTH(ttaxe_detail_profession.created_at),"00",ttaxe_detail_profession.id) as codeCarte')
    ->where([
        ['ttaxe_detail_profession.id_profession','=', $id_profession]
    ])    
    ->orderBy("ttaxe_detail_profession.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='<tr style="vertical-align:top;">
		<td style="width:0px;height:24px;"></td>
		<td></td>
		<td class="cs463A9CD7" style="width:46px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
		<td class="cs6AEC9C2" colspan="3" style="width:91px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->codeCarte.'</nobr></td>
		<td class="cs6AEC9C2" colspan="2" style="width:196px;height:22px;line-height:10px;text-align:left;vertical-align:middle;"><nobr>'.$row->colNom_Ese.'</nobr></td>
		<td class="cs6AEC9C2" colspan="2" style="width:108px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_secteur.'</nobr></td>
		<td class="cs6AEC9C2" colspan="4" style="width:141px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_profession.'</nobr></td>
		<td class="cs6AEC9C2" colspan="2" style="width:65px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->colCreatedBy_Ese.'</nobr></td>
	</tr>';
    }

    return $output;

}

    



///====================== LISTE DES TAXES PAR CATEGORIE========================

//==================== RAPPORT DES CONTRAT PAR DATE TYPE CONTRAT =======================================

public function fetch_rapport_liste_taxe_categorie(Request $request)
{
    if ($request->get('id_categorie_taxe')) {
        // code...
        $id_categorie_taxe = $request->get('id_categorie_taxe');
        
        $html = $this->printRapportListeTaxeByCategorie($id_categorie_taxe);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
}

function printRapportListeTaxeByCategorie($id_categorie_taxe)
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
            $bp=$row->edition;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
         }
 


        $output='';           

        $output='

               <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptListeTaxe</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs275E312D {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csDC7EEB9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:694px;height:305px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:62px;"></td>
                        <td style="height:0px;width:181px;"></td>
                        <td style="height:0px;width:8px;"></td>
                        <td style="height:0px;width:77px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:74px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="5" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:131px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:110px;">
                            <img alt="" src="'.$pic2.'" style="width:131px;height:110px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="7" style="width:498px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="7" style="width:498px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Taxe Forestier</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="7" style="width:498px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM&nbsp;'.$rccmEse.'.&nbsp;ID&nbsp;NAT&nbsp;'.$idNatEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="7" style="width:498px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;'.$numImpotEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="7" rowspan="2" style="width:498px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="7" style="width:498px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="7" style="width:498px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Site-web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="7" style="width:498px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'</nobr></td>
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
                        <td class="cs275E312D" style="width:40px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="csAB3AA82A" colspan="2" style="width:175px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Exploitation</nobr></td>
                        <td class="csAB3AA82A" colspan="2" style="width:188px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Categorie</nobr></td>
                        <td class="csAB3AA82A" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="csAB3AA82A" colspan="3" style="width:125px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Unit&#233;</nobr></td>
                        <td class="csAB3AA82A" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Quotit&#233;</nobr></td>
                    </tr>
                    ';
                                                                                
                        $output .= $this->showRapportListeTaxeByCategorie($id_categorie_taxe); 
                                                    
                    $output.='
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs5EA817F2" colspan="2" style="width:152px;height:22px;line-height:15px;text-align:center;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Kisangani&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>
        
        ';  
       
        return $output; 

}

function showRapportListeTaxeByCategorie($id_categorie_taxe)
{
    $count=0;

    $data = DB::table('taxe_exploitation')
    ->join('ttaxe_categorie' , 'ttaxe_categorie.id','=','taxe_exploitation.id_categorie_taxe') 
    ->join('taxe_unite' , 'taxe_unite.id','=','ttaxe_categorie.id_unite')
    ->select("taxe_exploitation.id",'nom_exploitation','id_categorie_taxe',
    'designation','prix_categorie','prix_categorie2','id_unite','quotite','nom_unite',
    "taxe_exploitation.created_at")     
    ->where([
        ['taxe_exploitation.id_categorie_taxe','=', $id_categorie_taxe]
    ])
    ->orderBy("taxe_exploitation.nom_exploitation", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csFBCBEF30" style="width:40px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csDC7EEB9" colspan="2" style="width:175px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$row->nom_exploitation.'</nobr></td>
                <td class="csDC7EEB9" colspan="2" style="width:188px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$row->designation.'</nobr></td>
                <td class="csDC7EEB9" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row->prix_categorie.'$</nobr></td>
                <td class="csDC7EEB9" colspan="3" style="width:125px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_unite.'</nobr></td>
                <td class="csDC7EEB9" style="width:73px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row->quotite.'&nbsp;%</nobr></td>
            </tr>
        ';
         
    }

    return $output;
}

    
    

    
}
