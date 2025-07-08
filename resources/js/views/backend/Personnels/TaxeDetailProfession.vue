<template>
    <v-row justify="center">
      <v-dialog v-model="etatModal" persistent max-width="1500px">
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
  
              <v-layout>
  
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="600px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Paiement Taxe <v-spacer></v-spacer>
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
  
                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez la Profession" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="professionList"
                                  item-text="nom_profession" item-value="id" dense outlined v-model="svData.id_profession"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>
  
                              <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-text-field type="date" label="Date Debut" prepend-inner-icon="event" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_debut">
                                    </v-text-field>
                                </div>
                              </v-flex>
  
                              <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-text-field type="date" label="Date Fin" prepend-inner-icon="event" dense
                                         outlined v-model="svData.date_fin">
                                    </v-text-field>
                                </div>
                              </v-flex>
  
                          </v-layout>
  
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                          <v-btn color="  blue" dark :loading="loading" @click="validate">
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
                          <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                            solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                            clearable></v-text-field>
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
                                <v-btn @click="dialog = true" fab color="  blue" dark>
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
                                  <th class="text-left">Menage</th>
                                  <th class="text-left">Secteur</th>
                                  <th class="text-left">Profession</th>
                                  <th class="text-left">DateDebut</th>
                                  <th class="text-left">DateFin</th>  
                                  <th class="text-left">Author</th>                        
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.colProprietaire_Ese }}</td>
                                  <td>{{ item.nom_secteur }}</td>
                                  <td>{{ item.nom_profession }}</td>
                                  <td>{{ item.date_debut }}</td>
                                  <td>{{ item.date_fin }}</td>
                                  <td>{{ item.author }}</td>
                                  <td>
                                    <v-tooltip v-if="userData.roles == 1" top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="editData(item.id)" fab small>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Modifier</span>
                                    </v-tooltip>
  
                                    <v-tooltip v-if="userData.roles == 1" top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="deleteData(item.id)" fab small>
                                            <v-icon color="  red">delete</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Suppression</span>
                                    </v-tooltip>
  
                                    <v-tooltip  top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="printBill(item.id)" fab small><v-icon
                                              color="blue">print</v-icon></v-btn>
                                        </span>
                                      </template>
                                      <span>Imprimer la Carte de Membre</span>
                                    </v-tooltip>
  
                                    <v-tooltip  top color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="printFiche(item.id)" fab small><v-icon
                                            color="blue">print</v-icon></v-btn>
                                      </span>
                                    </template>
                                    <span>Imprimer Note de Perception</span>
                                  </v-tooltip>
  
                                  </td>
                                </tr>
                              </tbody>
                            </template>
                          </v-simple-table>
                          <hr />
  
                          <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
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
  export default {
    data() {
      return {
  
        title: "Liste des Details",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        etatModal: false,
        titleComponent: '',
        id_personne: 0,
        //'id','id_personne','id_profession','date_debut','date_fin','author','refUser'
  
        svData: {
          id: '',
          id_personne: 0,
          id_profession:0,
          date_debut:'',
          date_fin:'',
          author: '',
          refUser:0,
        },
        fetchData: [],
        professionList: [],
        don: [],
        query: "",
          
  
          modifier:'',
          supprimer:'',
          chargement:''
  
      }
    },
    created() {     
      // this.fetchDataList();
      // this.fetchListProfession();
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
            this.svData.id_personne = this.id_personne;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_taxe_detail_profession/${this.svData.id}`,
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
            this.svData.id_personne = this.id_personne;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_taxe_detail_profession`,
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
      fetchListProfession() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_taxe_profession2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.professionList = donnees;
          }
        );
  
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_taxe_detail_profession/${id}`).then(
          ({ data }) => {
            this.titleComponent = "modification des Informations "; 
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_taxe_detail_profession/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
  
      printBill(id) {
        window.open(`${this.apiBaseURL}/fetch_carte_membre?id=` + id);
      },
      printFiche(id) {
        window.open(`${this.apiBaseURL}/pdf_fiche_perception?id=` + id); 
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_taxe_detail_profession/${this.id_personne}?page=`);
      }
    },
    filters: {
  
    }
  }
  </script>
    
    