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
          <!-- layout  -->

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
                              <v-autocomplete label="Selectionnez l'agent" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList"
                                item-text="noms_agent" item-value="id" dense outlined v-model="svData.refAgent"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>

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

                            <!-- @change="fetchListSelectionPoste()" -->

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez la Categorie Taxe" prepend-inner-icon="mdi-map" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="compteList" item-text="designation"
                                  item-value="id" outlined v-model="svData.refCompte" @change="fetchListExploitation()">
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Type d'exploitation" prepend-inner-icon="mdi-map" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="exploitationList" item-text="nom_exploitation"
                                  item-value="id" outlined v-model="svData.refExploitation">
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Prix Unitaire" prepend-inner-icon="extension" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montant">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Quantité" prepend-inner-icon="extension" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qte">
                                </v-text-field>
                              </div>
                            </v-flex>



                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Recouvrement" prepend-inner-icon="extension" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.recouvrement">
                                </v-text-field>
                              </div>
                            </v-flex>                           
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Marque Vehicule" prepend-inner-icon="extension" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.marque_vehicule">
                                </v-text-field>
                              </div>
                            </v-flex>


                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Lieu de Chargement" prepend-inner-icon="extension" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.lieu_chargement">
                                </v-text-field>
                              </div>
                            </v-flex>
                             <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Destination" prepend-inner-icon="extension" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.destination">
                                </v-text-field>
                              </div>
                            </v-flex>


                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="N° Bordereau" prepend-inner-icon="extension" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.bordereau">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Observations" prepend-inner-icon="extension" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.observations">
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
                                <th class="text-left">Agent</th>
                                <th class="text-left">Assujétie</th>
                                <th class="text-left">CatTaxe</th>
                                <th class="text-left">Pu</th>
                                <th class="text-left">Qté</th>
                                <th class="text-left">PT</th>
                                <th class="text-left">Quotité</th>
                                <th class="text-left">DateOperation</th>
                                <th class="text-left">MontantLettre</th>  
                                <th class="text-left">Mois</th>  
                                <th class="text-left">Année</th>                          
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_agent }}</td>
                                <td>{{ item.colProprietaire_Ese }}</td>
                                <td>{{ item.categorietaxe }}</td>
                                <td>{{ item.montant }}</td>
                                <td>{{ item.qte }}</td>
                                <td>{{ item.montant_total }}</td>
                                <td>{{ item.montant_quotite }}</td>
                                <td>{{ item.dateOperation }}</td>
                                <td>{{ item.montantLettre }}</td>
                                <td>{{ item.name_mois }}</td>
                                <td>{{ item.name_annee }}</td>
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

                                  <!-- <v-tooltip  top color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="printBill(item.id)" fab small><v-icon
                                            color="blue">print</v-icon></v-btn>
                                      </span>
                                    </template>
                                    <span>Imprimer FIche de Recensement</span>
                                  </v-tooltip> -->

                                  <!-- <v-tooltip  top color="black">
                                  <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                      <v-btn @click="printFiche(item.id)" fab small><v-icon
                                          color="blue">print</v-icon></v-btn>
                                    </span>
                                  </template>
                                  <span>Imprimer Note de Perception</span>
                                </v-tooltip> -->

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
      refEse: 0,
      //'id','montant','montantLettre','motif','dateOperation', 'refEse','refCompte','refAgent','author'

      //,'qte','recouvrement','refExploitation','marque_vehicule','lieu_chargement',
    //'destination','bordereau','observations'

      svData: {
        id: '',
        refEse: 0,
        refAgent:0,
        refMois:0,
        refAnnee:0,
        refCompte:0,
        montant:0,
        author: '',
        qte: 0,
        recouvrement: 0,
        refExploitation: 0,
        marque_vehicule: '',
        lieu_chargement: '',
        destination: '',
        bordereau: '',
        observations: '',
      },
      fetchData: [],
      agentList: [],
      anneeList: [],
      moisList: [],
      compteList: [],
      exploitationList: [],
      don: [],
      query: ""

    }
  },
  created() {     
    // this.fetchDataList();
    // this.fetchListAgent();
    // this.fetchListAnnee();
    // this.fetchListMois();
    // this.fetchListCompte();
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
          this.svData.refEse = this.refEse;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_taxe_paiement/${this.svData.id}`,
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
          this.svData.refEse = this.refEse;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_taxe_paiement`,
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
    fetchListAgent() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.agentList = donnees;
        }
      );

    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_taxe_paiement/${id}`).then(
        ({ data }) => {
          // var donnees = data.data;
          this.titleComponent = "modification des Informations ";
          // donnees.map((item) => {
          //   this.titleComponent = "modification de " + item.nom_circontstance;
          // });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_taxe_paiement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_note_perception?id=` + id);
    },
    printFiche(id) {
      window.open(`${this.apiBaseURL}/pdf_fiche_perception?id=` + id); 
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_taxe_paiement/${this.refEse}?page=`);
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
          //exploitationList
        }
      );
    },
    fetchListCompte() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_Taxe2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.compteList = donnees;
          //
        }
      );
    },
    fetchListExploitation() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_taxe_exploitation_by_categorie/${this.svData.refCompte}`).then(
        ({ data }) => {
          var donnees = data.data;
          this.exploitationList = donnees;
          //
        }
      );
    }
  },
  filters: {

  }
}
</script>
  
  