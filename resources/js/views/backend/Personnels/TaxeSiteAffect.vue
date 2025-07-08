<template>
  <v-layout>
    <v-flex md2></v-flex>
    <v-flex md8>
      <v-flex md12>
        <!--  -->
        <!-- modal -->
        <v-dialog v-model="dialog" max-width="400px" scrollable transition="dialog-bottom-transition">
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                {{ titleComponent }} <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = false" text fab depressed>
                        <v-icon>close</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Fermer</span>
                </v-tooltip></v-card-title>
              <v-card-text>
                <v-text-field label="Designation" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_site_affect">
                </v-text-field>

                <v-autocomplete label="Selectionnez l'Antenne"
                     prepend-inner-icon="mdi-map" :rules="[(v) => !!v || 'Ce champ est requis']"
                     :items="antenneList" item-text="nom_antene" item-value="id" dense
                     outlined v-model="svData.id_antene" chips clearable 
                     @change="fetchListSelectionPoste()">
                 </v-autocomplete>

                 <v-autocomplete label="Selectionnez le Poste"
                     prepend-inner-icon="mdi-map" :rules="[(v) => !!v || 'Ce champ est requis']"
                     :items="posteList" item-text="nom_poste" item-value="id" dense
                     outlined v-model="svData.id_poste_affect" chips clearable
                     @change="fetchListSelectionSousPoste()">
                 </v-autocomplete>

                 <v-autocomplete label="Selectionnez le Sous Poste"
                     prepend-inner-icon="mdi-map" :rules="[(v) => !!v || 'Ce champ est requis']"
                     :items="sousposteList" item-text="nom_sous_poste" item-value="id" dense
                     outlined v-model="svData.id_sous_poste_affect" chips clearable>
                 </v-autocomplete>
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
          <v-flex md6>
            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded hide-details
              v-model="query" @keyup="onPageChange" clearable></v-text-field>
          </v-flex>

          <v-flex md4></v-flex>

          <v-flex md1>
            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="showModal" fab color="  blue" dark>
                    <v-icon>add</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Ajouter une opération</span>
            </v-tooltip>
          </v-flex>
        </v-layout>
        <!-- bande -->

        <br />
        <v-card :loading="loading" :disabled="isloading">
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Designation</th>
                    <th class="text-left">SousPoste</th>
                    <th class="text-left">Poste</th>
                    <th class="text-left">Antenne</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.nom_site_affect }}</td>
                    <td>{{ item.nom_sous_poste }}</td>
                    <td>{{ item.nom_poste }}</td>
                    <td>{{ item.nom_antene }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-tooltip top color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <!-- <v-tooltip top   color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="clearP(item.id)" fab small><v-icon color="  red">delete</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Supprimer</span>
                      </v-tooltip> -->
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <hr />

            <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total" @input="onPageChange"
              :total-visible="7"></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
    <v-flex md2></v-flex>
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  components: {},
  data() {
    return {
      title: "Categorie component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,      
      svData: {
        id: "",
        nom_site_affect: "",
        id_sous_poste_affect: 0,
        id_poste_affect: 0,
        id_antene : 0
      },
      fetchData: null,
      titreModal: "",
      antenneList: [],
      posteList: [],
      sousposteList: [],
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''
    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Site";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.nom_site_affect;
      } else {
        this.titleComponent = "Ajout Site";
      }
    }
    ,
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_taxe_site_affect?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_taxe_site_affect`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_taxe_site_affect/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.nom_site_affect;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_taxe_site_affect/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
    fetchListSelectionAntenne() {
       this.editOrFetch(`${this.apiBaseURL}/fetch_taxe_antene2`).then(
         ({ data }) => {
             var donnees = data.data;
             this.antenneList = donnees;
         }
       );
    },
    fetchListSelectionPoste() {
       this.editOrFetch(`${this.apiBaseURL}/fetch_taxe_poste_by_antene/${this.svData.id_antene}`).then(
         ({ data }) => {
             var donnees = data.data;
             this.posteList = donnees;
         }
       );
    },
    fetchListSelectionSousPoste() {
       this.editOrFetch(`${this.apiBaseURL}/fetch_taxe_sous_poste_by_poste/${this.svData.id_poste_affect}`).then(
         ({ data }) => {
             var donnees = data.data;
             this.sousposteList = donnees;
         }
       );
    },


  },
  created() {
     
    this.testTitle();
    this.onPageChange();
    this.fetchListSelectionAntenne();
  },
};
</script>