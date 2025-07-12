<template>
    <v-layout wrap row>
        
        <v-flex md12>
            <v-flex md12>
                <!-- modal  -->
                <!-- <detailLotModal v-on:chargement="rechargement" ref="detailLotModal" /> -->
                <!-- fin modal -->
                <!-- modal -->
               <br><br>
                <!-- fin modal -->

                <!-- bande -->
                <v-layout>
                    <v-flex md1>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn :loading="loading" fab @click="onPageChange">
                                        <v-icon>autorenew</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Initialiser</span>
                        </v-tooltip>
                    </v-flex>
                    <v-flex md7>

                        <v-row v-show="showDate">
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-date-picker
                                v-model="dates"
                                range
                            ></v-date-picker>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-text-field
                                v-model="dateRangeText"
                                label="Date range"
                                prepend-icon="mdi-calendar"
                                readonly
                            ></v-text-field>
                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowClient" block color="primary">
                                            <v-icon>print</v-icon> LISTE DES CLIENTS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> -->
                            <br>

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showExpeditionByDate" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES EXPEDITIONS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDepenseExpeditionByDate" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES DEPENSES(EXP.)
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowListeTaxeParCategorie" block color="primary">
                                            <v-icon>print</v-icon> LISTE DES TAXES/CATEGORIE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>
                            <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'Encodeur" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="encodeurList"
                                item-text="noms" item-value="code_encodeur" dense outlined v-model="svData.code_encodeur"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                            
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowEncodageByDate_Encodeur" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES RESENCEMENTS/ENCODEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowRecetteByDate" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES RECETTES/TAXES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <!-- PrintshowStatistiqueEncodeurByDate -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowStatistiqueByDate" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT STATISTIQUE/QUARTIER
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <!-- PrintshowStatistiqueEncodeurByDate -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowStatistiqueEncodeurByDate" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT STATISTIQUE/ENCODEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'agent" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList"
                                item-text="noms_agent" item-value="id" dense outlined v-model="svData.refAgent"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-tooltip bottom color="black">
                            <!-- PrintshowRecetteByDate_Superviseur -->
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowRecetteByDate_Agent" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES RECETTES/AGENT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            <v-tooltip bottom color="black">
                            <!-- PrintshowRecetteByDate_Superviseur -->
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowRecetteByDate_Superviseur" block color="primary">
                                            <v-icon>print</v-icon> RELEVE DE COLLECTE/AGENT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Pays" prepend-inner-icon="home"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="paysList"
                                            item-text="nomPays" item-value="id" dense outlined v-model="svData.idPays"
                                            chips clearable @change="get_data_tug_pays(svData.idPays)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la province" prepend-inner-icon="map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.provinceList" item-text="nomProvince" item-value="id"
                                            dense outlined v-model="svData.idProvince" clearable chips
                                            @change="get_data_tug_province(svData.idProvince)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la ville" prepend-inner-icon="explore"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.villeList"
                                            item-text="nomVille" item-value="id" dense outlined v-model="svData.idVille"
                                            clearable chips @change="get_data_tug_commune(svData.idVille)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowRecetteByDate_Ville" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES RECETTES/VILLE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la commune" prepend-inner-icon="push_pin"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.communeList" item-text="nomCommune" item-value="id" dense
                                            outlined v-model="svData.idCommune" clearable
                                            @change="get_data_tug_quartier(svData.idCommune)" chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le quartier" prepend-inner-icon="navigation"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.quartierList" item-text="nomQuartier" item-value="id"
                                            dense outlined v-model="svData.ColRefQuartier" clearable chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <!-- <br> -->
                            <!--  -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowRecetteByDate_Quartier" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES RECETTES/QUARTIER
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le quartier" prepend-inner-icon="navigation"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.quartierList" item-text="nomQuartier" item-value="nomQuartier"
                                            dense outlined v-model="svData.colQuartier_Ese" clearable chips>
                                        </v-autocomplete>
                                    </div>
                            </v-flex>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowEncodageByDate_Quartier" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES RESENCEMENTS/QUARTIER
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez le Mois" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="moisList" item-text="name_mois"
                                    item-value="id" dense outlined v-model="svData.refMois" chips clearable>
                                    </v-autocomplete>
                                </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                <v-autocomplete label="Selectionnez l'année" prepend-inner-icon="mdi-map" dense
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="anneeList" item-text="name_annee"
                                    item-value="id" outlined v-model="svData.refAnnee">
                                </v-autocomplete>
                                </div>
                            </v-flex>

                             <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowRecetteByDate_Mois_Annee" block color="primary">
                                            <v-icon>print</v-icon> RAPPORT DES RECETTES/MOIS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez la Profession" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="professionList"
                                  item-text="nom_profession" item-value="id" dense outlined v-model="svData.id_profession"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>
                            <!-- <br> PrintshowListeTaxeParCategorie -->

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowListeMembre_Profession" block color="primary">
                                            <v-icon>print</v-icon> LISTE DES MEMBRES/PROFESSION
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowListeTaxeParCategorie" block color="primary">
                                            <v-icon>print</v-icon> LISTE DES TAXES/CATEGORIE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            
                            </v-col>
                        </v-row>
                      
                    </v-flex>
                   

                    <v-flex md3>
                       
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="compteList"
                                item-text="designation" item-value="id" dense outlined v-model="svData.refCompte"
                                chips clearable >
                            </v-autocomplete>
                        </div>
                    </v-flex>

                    <v-flex md1>
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="showDate = !showDate" fab color="primary">
                                        <v-icon>mdi-calendar</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Ajouter une opération</span>
                        </v-tooltip>
                    </v-flex>
                </v-layout>
                <!-- bande -->

                
            </v-flex>
        </v-flex>
        
    </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
// import detailLotModal from './detailLotModal.vue'
export default {
    components: {
        // detailLotModal,
    },
    data() {
        return {
            title: "Pays component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",
                idEntreprise: "",
                id_tarif: "",
                id_agent:[],
                remise: 0,
                ceo: "",
                selectionAgent:[],
                refCompte: "", 
                refTrajectoire:0,
                refTypetarification:0,
                refBanque:0,
                nom_mode:"",
                nomEncodeur:"",
                code_encodeur : "",
                colQuartier_Ese: "",

                refAgent:0,
                ColRefQuartier:0,
                idCommune:0,
                idVille:0,
                idPays: "",
                idProvince: "",

                refMois:0,
                refAnnee:0,
                
            },
            stataData: {
                entrepriseList: [],
                paysList: [],
                provinceList: [],
                villeList: [],
                communeList:[],
                quartierList:[]

            },
            professionList: [],
            fetchData: null,
            BanqueList: [],
            ModeList: [],
            titreModal: "",
            typetarifList: [],    
            trajectoireList: [],
            compteList: [],
            agentList: [],
            encodeurList: [],

            anneeList: [],
            moisList: [],

            filterValue:'',
            dates:[],
            showDate:true,
            
        };
    },
    computed: {
        ...mapGetters(["basicList", "paysList",
        "provinceList", "ListeEdition", "entrepriseList", "isloading"]),
        dateRangeText () {
            return this.dates.join(' ~ ')
        },
    },
    methods: {
        ...mapActions(["getBasic", "getPays", "getCategorie",
            "getProvince", "getEntrepriseList", "getMyEntrepriseList"]),
        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Tarification ";
            this.edit = false;
            this.resetObj(this.svData);
            this.svData.id_agent=[];
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de Tarification ";
            } else {
                this.titleComponent = "Ajout Tarification ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),

        
        onPageChange() {
            if (this.dates.length >= 1) {
                this.showCardByDate();
            } else {
                this.fetch_data(`${this.apiBaseURL}/fetch_abonnement_carte?page=`);                
            }
           
        },
  
        fetchListTypeTarif() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_typetarif`).then(
            ({ data }) => {
                var donnees = data.data;
                this.typetarifList = donnees;
            }
            );
        },
        fetchListAgent() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
            ({ data }) => {
            var donnees = data.data;
            this.agentList = donnees;
            }
        );

        },
        fetchListEncodeur() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_econdeur2`).then(
            ({ data }) => {
            var donnees = data.data;
            this.encodeurList = donnees;
            }
        );

        },
        
        fetchListTrajectoire() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_trajectoire`).then(
            ({ data }) => {
                var donnees = data.data;
                this.trajectoireList = donnees;
            }
            );
        },  
        fetchListCompte() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_Taxe2`).then(
            ({ data }) => {
                var donnees = data.data;
                this.compteList = donnees;
            }
            );
        },

        showExpeditionByDate() {
            //fetch_carte_membre
            //fetch_rapport_liste_membres_profession
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_expedition_date?date1=` + date1+"&date2="+date2+"&refCompte="+this.svData.refCompte);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
           
           
        },

        showDepenseExpeditionByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_depense_expedition_date?date1=` + date1+"&date2="+date2+"&refCompte="+this.svData.refCompte);            
            
            } else {
            this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        
        
        },

        PrintshowTarification() {          
            window.open(`${this.apiBaseURL}/fetch_rapport_tarification?refTrajectoire=` + this.svData.refTrajectoire+"&refTypeTarif="+this.svData.refTypetarification);           
        },

        PrintshowClient() {
            window.open(`${this.apiBaseURL}/pdf_listeclient_data`);
        
        //fetch_rapport_depense_date
        },
        PrintshowPaieByDate() {

            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_paie_expedition_date?date1=` + date1+"&date2="+date2+"&refCompte="+this.svData.refCompte);                          
            
            } else {
            this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
              
           
           //fetch_rapport_dette_date
        },
        PrintshowDepenseByDate() {

            // if (this.userData.id_role == 1 || this.userData.id_role == 2) {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {
                    window.open(`${this.apiBaseURL}/fetch_rapport_depense_compte_date?date1=` + date1 + "&date2=" + date2+"&refCompte="+this.svData.refCompte);
                    //window.open(`${this.apiBaseURL}/fetch_rapport_depense_date?date1=` + date1+"&date2="+date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
            // } else {
            //     this.showError("Cette action est reservée uniquement aux administrateurs du système!!!");
            // }          
           //fetch_rapport_paie_date
        },
        PrintshowRecetteByDate() {

            // if (this.userData.id_role == 1 || this.userData.id_role == 2) {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_entree_compte_date?date1=` + date1 + "&date2=" + date2+"&refCompte="+this.svData.refCompte);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
            // } else {
            //     this.showError("Cette action est reservée uniquement aux administrateurs du système!!!");
            // }

           
           
           //fetch_rapport_paie_date
        },
        PrintshowStatistiqueByDate() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_statistique_quartier_date?date1=` + date1 + "&date2=" + date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowStatistiqueEncodeurByDate() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_statistique_encodeur_date?date1=` + date1 + "&date2=" + date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowRecetteByDate_Superviseur() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_releve_agent_date?date1=` + date1 + "&date2=" + date2+"&refAgent="+this.svData.refAgent);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }   
        },
        PrintshowEncodageByDate_Quartier() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_encodage_quartier_date?date1=` + date1 + "&date2=" + date2+"&colQuartier_Ese="+this.svData.colQuartier_Ese);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }   
        },
        PrintshowEncodageByDate_Encodeur() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_encodage_agent_date?date1=` + date1 + "&date2=" + date2+"&nomEncodeur="+this.svData.code_encodeur);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }   
        },
        PrintshowRecetteByDate_Ville() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_entree_ville_date?date1=` + date1 + "&date2=" + date2+"&idVille="+this.svData.idVille);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }   
        },
        PrintshowRecetteByDate_Agent() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_entree_agent_date?date1=` + date1 + "&date2=" + date2+"&refAgent="+this.svData.refAgent);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }   
        },
        PrintshowRecetteByDate_Quartier() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_entree_quartier_date?date1=` + date1 + "&date2=" + date2+"&ColRefQuartier="+this.svData.ColRefQuartier);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }   
        },
        PrintshowRecetteByDate_Mois_Annee() {

            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                if(this.svData.refMois != '' && this.svData.refAnnee != '')
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiement_mensuel_date?date1=` + date1+"&date2="+date2+"&refAnnee="+this.svData.refAnnee+"&refMois="+this.svData.refMois);
                }
                                   
                } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        PrintshowListeMembre_Profession() {            
            if(this.svData.id_profession != '')
            {
              window.open(`${this.apiBaseURL}/fetch_rapport_liste_membres_profession?id_profession=` + this.svData.id_profession);
            }
        },
        PrintshowListeTaxeParCategorie() {            
            if(this.svData.refCompte != '')
            {
              window.open(`${this.apiBaseURL}/fetch_rapport_liste_taxe_categorie?id_categorie_taxe=` + this.svData.refCompte);
            }
        },
        PrintshowDepenseBanqueByDate() {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {
                    window.open(`${this.apiBaseURL}/fetch_banque_sortie_date?date1=` + date1+"&date2="+date2+"&refCompte="+this.svData.refCompte+"&refBanque="+this.svData.refBanque);                   
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
           
        },
        PrintshowRecetteBanqueByDate() {

                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {
                    window.open(`${this.apiBaseURL}/fetch_banque_entree_date?date1=` + date1+"&date2="+date2+"&refCompte="+this.svData.refCompte+"&refBanque="+this.svData.refBanque);                         
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
            
        },

       
        //fin chargement des agents

        showDetailModalLot(codeR) {
        
            if (codeR !=null) {
                
            } else {
                this.showError("Aucune action  n'a été faite!!! prière de selectionner un lot de commande");
            }
    
        },
        

        rechargement()
        {
            this.onPageChange();
            
        },
      async get_mode_Paiement() {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_mode`)
              .then((res) => {
              var chart = res.data.data;              
              if (chart) {
                  this.ModeList = chart;
              } else {
                  this.ModeList = [];
              }

              this.isLoading(false);

              //   console.log(this.stataData.car_optionList);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
      },
      async get_Banque(nom_mode) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_banque/${nom_mode}`)
              .then((res) => {
              var chart = res.data.data;              
              if (chart) {
                  this.BanqueList = chart;
              } else {
                  this.BanqueList = [];
              }
              this.isLoading(false);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
      },

        //les operation commence
        //fultrage de donnees
        async get_data_tug_pays(id_pays) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_province_tug_pays/${id_pays}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.provinceList = chart;
                    } else {
                        this.stataData.provinceList = [];
                    }

                    this.isLoading(false);

                    //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },

        async get_data_tug_province(idProvince) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_ville_tug_pays/${idProvince}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.villeList = chart;
                    } else {
                        this.stataData.villeList = [];
                    }

                    this.isLoading(false);

                    //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },

        async get_data_tug_commune(idVille) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_commune_tug_ville/${idVille}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.communeList = chart;
                    } else {
                        this.stataData.communeList = [];
                    }

                    this.isLoading(false);

                    //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },

        async get_data_tug_quartier(idCommune) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_quartier_tug_commune/${idCommune}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.quartierList = chart;
                    } else {
                        this.stataData.quartierList = [];
                    }

                    this.isLoading(false);

                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },
    fetchListAnnee() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_annee_encours`).then(
        ({ data }) => {
          var donnees = data.data;
          this.anneeList = donnees;

        }
      );
    },
    fetchListMois() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_mois`).then(
        ({ data }) => {
          var donnees = data.data;
          this.moisList = donnees;
        }
      );
    },
      fetchListProfession() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_taxe_profession2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.professionList = donnees;
          }
        );
  
      },

       


    },
    created() {
        this.fetchListTrajectoire();
        this.fetchListTypeTarif();
        this.fetchListCompte();  
        this.fetchListEncodeur(); 
        this.getPays();  
        this.fetchListAgent();  
        this.fetchListAnnee();
        this.fetchListMois(); 
        this.fetchListProfession();
    },
};
</script>