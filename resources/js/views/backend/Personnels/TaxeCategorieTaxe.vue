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
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designation"></v-text-field>

                  <v-text-field label="Prix (FC)" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prix_categorie"></v-text-field>

                  <v-text-field label="Prix2 (FC)" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prix_categorie2"></v-text-field>

                  <v-autocomplete label="Selectionnez l'Unité"
                     prepend-inner-icon="mdi-map" :rules="[(v) => !!v || 'Ce champ est requis']"
                     :items="uniteList" item-text="nom_unite" item-value="id" dense
                     outlined v-model="svData.id_unite" chips clearable>
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
                    <th class="text-left">Montant(FC)</th>
                    <th class="text-left">Montant2(FC)</th>
                    <th class="text-left">Unité</th>
                    <th class="text-left">Quotité</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.designation }}</td>
                    <td>{{ item.prix_categorie }}</td>
                    <td>{{ item.prix_categorie2 }}</td>
                    <td>{{ item.nom_unite }}</td>
                    <td>{{ item.quotite }}</td>
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

                      <v-tooltip top   color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="clearP(item.id)" fab small><v-icon color="  red">delete</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Supprimer</span>
                      </v-tooltip>
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
        designation: "",
        prix_categorie : 0,
        prix_categorie2 : 0,
        id_unite : 0,
        quotite : 0,
      },
      fetchData: null,
      titreModal: "",
      uniteList: [], 

    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout mutuelle";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.designation;
      } else {
        this.titleComponent = "Ajout Categorie";
      }
    }
    ,
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_catTaxe?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_catTaxe`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_catTaxe/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.designation;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_catTaxe/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
    fetchListSelectionUnite() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_taxe_unite2`).then(
            ({ data }) => {
                var donnees = data.data;
                this.uniteList = donnees;
            }
        );
    },


  },
  created() {
     
    this.testTitle();
    this.onPageChange();
    this.fetchListSelectionUnite();
  },
};
</script>