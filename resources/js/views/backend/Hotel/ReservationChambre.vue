<template>

    <v-row justify="center">
        <v-dialog v-model="etatModal" persistent max-width="1800px">
          <v-card>
            <!-- container -->
    
            <v-card-title class="primary">
              {{ titleComponent }} <v-spacer></v-spacer>
              <v-btn depressed text small fab @click="etatModal = false">
                <v-icon>close</v-icon>
              </v-btn>
            </v-card-title>
            <v-card-text>
              <!-- layout -->
    
              <div>

                <PaiementChambre ref="PaiementChambre" />
    
              <v-layout>
                
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="700px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Details Entrée <v-spacer></v-spacer>
                          <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="dialog = false" text fab depressed>
                                  <v-icon>close</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Fermer</span>
                          </v-tooltip>
                        </v-card-title>
                        <v-card-text>

                            <v-layout row wrap>

                              <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Entrée " prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_entree">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Sortie " prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_sortie">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Classe" prepend-inner-icon="mdi-map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="classeList"
                                            item-text="designation" item-value="id" dense outlined v-model="svData.refClasse"
                                            chips clearable @change="fetchListChambre()">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Chambre" prepend-inner-icon="mdi-map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="chambreList" item-text="nom_chambre"
                                            item-value="id" dense outlined v-model="svData.refChmabre" chips clearable @change="getPrice(svData.refChmabre)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" readonly label="Prix Chambre($)" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prix_unitaire">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Heure Entrée " prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heure_debut">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Heure Sortie " prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heure_sortie">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" label="Reduction" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.reduction">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Device" :items="[
                                            { designation: 'USD' },
                                            { designation: 'FC' },
                                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.devise">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Observations" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.observation">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Type Résérvation" :items="[
                                            { designation: 'Passage Simple' },
                                            { designation: 'Une Nuité' },
                                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.type_reservation">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Nom de l'Accompagné" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_accompagner">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Pays de Provinance" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pays_provenance">
                                        </v-text-field>
                                    </div>
                                </v-flex>




                            </v-layout>  

    
      
    
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                          <v-btn color="  primary" dark :loading="loading" @click="validate">
                            {{ edit ? "Modifier" : "Ajouter" }}
                          </v-btn>
                        </v-card-actions>
                      </v-form>
                    </v-card>
                  </v-dialog>
    
                  <br /><br />
                  <v-layout>
                    <!--   -->
                    <v-flex md12>
                      <v-layout>
                        <v-flex md6>
                          <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                            outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                        </v-flex>
                        <v-flex md5>
                          <div>
                            <!-- {{ this.don }} -->
                          </div>
                        </v-flex>
                        <v-flex md1>
                          <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="dialog = true" fab color="  primary" dark>
                                  <v-icon>add</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Ajouter le Detail</span>
                          </v-tooltip>
                        </v-flex>
                      </v-layout>
                      <br />
                      <v-card>
                        <v-card-text>
                          <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <tr>
                                  <th class="text-left">Client</th>
                                  <th class="text-left">Chambre</th>
                                  <th class="text-left">N°Chambre</th>
                                  <th class="text-left">Classe</th>
                                  <th class="text-left">TypeRes.</th>
                                  <th class="text-left">PU($)</th>
                                  <th class="text-left">DateEntrée</th>
                                  <th class="text-left">DateSortie</th>
                                  <th class="text-left">NombreJour</th>
                                  <th class="text-left">PT($)</th>
                                  <th class="text-left">Reduction($)</th>
                                  <th class="text-left">Montant($)</th>
                                  <th class="text-left">Taux</th>
                                  <th class="text-left">Author</th>
                                  <th class="text-left">Mise à jour</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.nom_chambre }}</td>
                                  <td>{{ item.numero_chambre }}</td>
                                  <td>{{ item.ClasseChambre }}</td>
                                  <td>{{ item.type_reservation }}</td>
                                  <td>{{ item.prix_chambre }}</td>
                                  <td>{{ item.date_entree }}</td>
                                  <td>{{ item.date_sortie }}</td>
                                  <td>{{ item.NombreJour }}</td>
                                  <td>{{ item.prixTotalSans }}</td>
                                  <td>{{ item.reduction }}</td>
                                  <td>{{ item.prixTotal }}</td>
                                  <td>{{ item.taux }}</td>
                                  <td>{{ item.author }}</td>
                                  <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                  </td>
                                  <td>

                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">

                            <v-list-item link @click="showPaiementChambre(item.id, item.noms,item.totalFacture,item.totalPaie,item.RestePaie)">
                              <v-list-item-icon>
                                <v-icon>mdi-cart-outline</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Paiement Facture
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printBill(item.id)">
                              <v-list-item-icon>
                                <v-icon color="primary">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Imprimer la Facture
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printFiche(item.id)">
                              <v-list-item-icon>
                                <v-icon color="primary">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Imprimer la Fiche pour Client
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item    link @click="editData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="primary">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Modifier
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item   link @click="deleteData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="red">delete</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Suppression
                              </v-list-item-title>
                            </v-list-item>

                          </v-list>
                        </v-menu>
    
                                  </td>
                                </tr>
                              </tbody>
                            </template>
                          </v-simple-table>
                          <hr />
    
                          <v-pagination color="  primary" v-model="pagination.current" :length="pagination.total"
                            @input="fetchDataList"></v-pagination>
                        </v-card-text>
                      </v-card>
                    </v-flex>
                    
                  </v-layout>
                </v-flex>
                
              </v-layout>
    
              </div>
            
    
              <!-- fin -->
            </v-card-text>
    
            <!-- container -->
          </v-card>
        </v-dialog>
      </v-row>
    
    
    
    
    </template>
    <script>
    import { mapGetters, mapActions } from "vuex";
    import PaiementChambre from './PaiementChambre.vue';
    

    export default {
      components:{
        PaiementChambre
      },
      data() {
        return {
    
          title: "Liste des Details",
          dialog: false,
          edit: false,
          loading: false,
          disabled: false,
          etatModal: false,
          titleComponent: '',
          refClient: 0,
    
          //'id','refClient','refChmabre','date_entree','date_sortie','heure_debut','heure_sortie','libelle',
        //'prix_unitaire','devise','taux','reduction','observation','type_reservation','nom_accompagner','pays_provenance','author'
          svData: {
            id: '',
            refClient: 0,
            refChmabre: 0,
            date_entree:"",
            date_sortie:"",
            heure_debut:"",
            heure_sortie:"",
            libelle:"",
            prix_unitaire: 0,
            devise:"",
            reduction:0,
            observation:"",
            type_reservation:"",
            nom_accompagner:"",
            pays_provenance:"",            
            author: "",

            refClasse: 0        
          },
          fetchData: [],
          chambreList: [],
          classeList: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        // this.fetchDataList();
        this.fetchListClasseChambre();
      },
      computed: {
        ...mapGetters(["categoryList", "isloading"]),
      },
      methods: {
    
        ...mapActions(["getCategory"]),
    
        validate() {
          if (this.$refs.form.validate()) {
            this.isLoading(true);
            if (this.edit) {
              this.svData.refClient = this.refClient;
              this.svData.author = this.userData.name;
              this.svData.libelle="Reservation Chambre";
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_hotel_reservation_chambre/${this.svData.id}`,
                JSON.stringify(this.svData)
              )
                .then(({ data }) => {
                  this.showMsg(data.data);
                  this.isLoading(false);
                  this.edit = false;
                  this.dialog = false;
                  this.resetObj(this.svData);
                  this.fetchDataList();
                })
                .catch((err) => {
                  this.svErr(), this.isLoading(false);
                });
    
            }
            else {
              this.svData.refClient = this.refClient;
              this.svData.author = this.userData.name;
              this.svData.libelle="Reservation Chambre";
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_hotel_reservation_chambre`,
                JSON.stringify(this.svData)
              )
                .then(({ data }) => {
                  this.showMsg(data.data);
                  this.isLoading(false);
                  this.edit = false;
                  this.dialog = false;
                  this.resetObj(this.svData);
                  this.fetchDataList();
                })
                .catch((err) => {
                  this.svErr(), this.isLoading(false);
                });
            }
    
          }
        },
    
        // s'id','refClient','refChmabre','prix_unitaire','qteVente','author'
        //   this.fetchDataList();
        // }, 300),
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_hotel_reservation_chambre/${id}`).then(
            ({ data }) => {
              var donnees = data.data;
            donnees.map((item) => {
                this.titleComponent = "modification de " + item.noms;
            });
            this.getSvData(this.svData, data.data[0]);
    
              this.edit = true;
              this.dialog = true;
    
              // console.log(donnees);
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_hotel_reservation_chambre/${id}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
              }
            );
          });
        },
    
        printBill(id) {
          window.open(`${this.apiBaseURL}/pdf_facture_hotel?id=` + id);
        },
    
        printFiche(id) {
          window.open(`${this.apiBaseURL}/pdf_fiche_hotel?id=` + id);
        },
        fetchDataList() {
          this.fetch_data(`${this.apiBaseURL}/fetch_hotel_reservation_chambre/${this.refClient}?page=`);
        },
    
        fetchListChambre() {
          // this.editOrFetch(`${this.apiBaseURL}/fetch_thotel_chambre_2`).then(
          //   ({ data }) => {
          //     var donnees = data.data;
          //     this.chambreList = donnees;
          //   }
          // );



          this.editOrFetch(`${this.apiBaseURL}/fetch_thotel_chambre_libre?date_entree=` + this.svData.date_entree+"&date_sortie="+this.svData.date_sortie+"&refClasse="+this.svData.refClasse).then(
            ({ data }) => {
              var donnees = data.data;
              this.chambreList = donnees;
            }
          );

        },
      fetchListClasseChambre() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_thotel_classe_chambre_2`).then(
              ({ data }) => {
                  var donnees = data.data;
                  this.classeList = donnees;

              }
          );

      },
    showPaiementChambre(refReservation, name,totalFacture,totalPaie,RestePaie) {

      if (refReservation != '') {
//
        this.$refs.PaiementChambre.$data.etatModal = true;
        this.$refs.PaiementChambre.$data.refReservation = refReservation;
        this.$refs.PaiementChambre.$data.totalFacture = totalFacture;
        this.$refs.PaiementChambre.$data.totalPaie = totalPaie;
        this.$refs.PaiementChambre.$data.RestePaie = RestePaie;
        this.$refs.PaiementChambre.fetchDataList();
        this.$refs.PaiementChambre.get_mode_Paiement();
        this.$refs.PaiementChambre.getInfoFacture();
        this.fetchDataList();

        this.$refs.PaiementChambre.$data.titleComponent =
          "Paiement Reservation Pour pour " + name+" : "+totalFacture;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
     getPrice(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_hotel_chambre/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.prix_unitaire = item.prix_chambre;       
            });
            // this.getSvData(this.svData, data.data[0]);           
          }
        );
      },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='thotel_reservation_chambre';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une facture de reservation de la chambre du client "+noms+" par l'utilisateur "+user_name+"" ;

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.onPageChange();
          }
        );
      });
    }
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      