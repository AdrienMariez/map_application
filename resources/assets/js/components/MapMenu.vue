<template>
    <div>

        <!-- <map-controls></map-controls> -->

        <v-navigation-drawer
            v-model="drawer"
            :mini-variant="mini"
            dark
            color="green darken-4"
            class="green darken-4"
            app>

            <!-- deploy full nav -->
            <v-list-tile v-if="mini" @click.stop="mini = !mini">
                <v-list-tile-action>
                    <v-icon>chevron_right</v-icon>
                </v-list-tile-action>
            </v-list-tile>

            <!-- fold full nav -->
            <v-list-tile v-if="!mini">
                <v-layout row wrap>
                    <v-flex xs6>
                        <v-list-tile-action
                            text-xs-center
                            align-center
                            justify-center
                            @click.stop="mini = !mini"
                            class="text-xs-center flexCenter">
                            <v-icon>
                                chevron_left
                            </v-icon>
                        </v-list-tile-action>
                    </v-flex>
            <!-- close full nav -->
                    <v-flex xs6 align-center>
                        <v-list-tile-action
                            text-xs-center
                            align-center
                            justify-center
                            @click.stop="drawer = !drawer"
                            class="text-xs-center flexCenter">
                            <v-icon>
                                close
                            </v-icon>
                        </v-list-tile-action>
                    </v-flex>
                </v-layout>
            </v-list-tile>

            <v-divider></v-divider>

            <v-spacer></v-spacer>

            <!-- switch language -->
            <v-list-tile @click.stop="fr = !fr">

                <!-- <v-list-tile-action>
                    <v-icon>language</v-icon>
                </v-list-tile-action>
                <v-list-tile-action class="white--text">
                    <v-list-tile-content
                        v-for="(item,i) in languages"
                        :key="i">
                        {{i}}
                    </v-list-tile-content>
                </v-list-tile-action> -->

                <v-list-tile-action>
                    <v-icon>language</v-icon>
                </v-list-tile-action>
                <v-list-tile-action class="white--text">
                    <v-list-tile-content v-if="fr">
                        English
                    </v-list-tile-content>
                    <v-list-tile-content v-if="!fr">
                        Français
                    </v-list-tile-content>
                </v-list-tile-action>
            </v-list-tile>

            <!-- // DUMMY NAV  -->
            <!-- <v-expansion-panel
                expand> -->
                <!-- loop on categories -->
                <!-- <v-expansion-panel-content
                v-for="(item,i) in 5"
                :key="i"
                color="green darken-3"
                class="green darken-3"> -->

                <!-- header -->
                <!-- <div 
                    slot="header">
                    <v-list class="noPaddingLeft">
                        <v-list-tile>
                            <v-list-tile-action>
                                <v-icon large color="brown lighten-4">
                                    home
                                </v-icon>
                            </v-list-tile-action>
                            <v-list-tile-action>
                                <v-list-tile-content v-if="fr">
                                    Categorie {{i}}
                                </v-list-tile-content>
                                <v-list-tile-content v-if="!fr">
                                    Category {{i}}
                                </v-list-tile-content>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                </div> -->

                <!-- loop on references in categories -->
                <!-- <v-list
                    class="pt-0"
                    v-for="(item,y) in 3"
                    :key="y">
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-icon color="blue darken-2">
                                grade
                            </v-icon>
                        </v-list-tile-action>
                        <v-list-tile-action>
                            <v-list-tile-content v-if="fr">
                                Reference {{y}} de {{i}}
                            </v-list-tile-content>
                            <v-list-tile-content v-if="!fr">
                                Element {{y}} of {{i}}
                            </v-list-tile-content>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>

                </v-expansion-panel-content>
            </v-expansion-panel> -->
            <!-- // END DUMMY NAV  -->

            <!-- TEST NAV -->
            <point-list-component
                v-for="point in points"
                v-bind="point"
                :key="point.id"
                @update="update"
                @delete="del"
            >
            </point-list-component>
            <!-- <div>
                <button @click="create()">Add</button>
            </div> -->
            <!-- END TEST NAV -->

        </v-navigation-drawer>

        <v-toolbar
            color="green darken-4"
            fixed
            app
            dense>
            <v-toolbar-side-icon
                v-if="!drawer"
                @click.stop="drawer = !drawer"
                 color="green darken-1">
            </v-toolbar-side-icon>
            <v-toolbar-title
                class="white--text">
                Carte interactive de Prayssac
            </v-toolbar-title>
        </v-toolbar>

        <v-card-text class="buttonContact">
            <v-btn
                absolute
                dark
                center
                color="green darken-3"
            >
                <div class="linkColor">Contact</div>
            </v-btn>
        </v-card-text>

    </div>

</template>

<script>
  function Point({ id, link, icon, color, longitude, lattitude, uses_image, image_path}) {
    this.id = id;
    this.link = link;
    this.icon = icon;
    this.color = color;
    this.longitude = longitude;
    this.lattitude = lattitude;
    this.uses_image = uses_image;
    this.image_path = image_path;
  }
  function Reference({ id, icon, color, weight, fk_category_id}) {
    this.id = id;
    this.icon = icon;
    this.color = color;
    this.weight = weight;
    this.fk_category_id = fk_category_id;
  }
function ReferenceName({ id, name}) {
    this.id = id;
    this.text = text;
    this.fk_language_id = fk_language_id;
  }
  function Category({ id, icon, color, weight}) {
    this.id = id;
    this.icon = icon;
    this.color = color;
    this.weight = weight;
  }
  function Language({ id, name}) {
    this.id = id;
    this.name = name;
  }
import MapControls from './MapControls.vue'
import PointListComponent from './PointList.vue';
  export default {
    data () {
      return {
        drawer: true,
        mini: false,
        fr: true,
        points: [],
        languages: [],
        categories: [],
        references: [],
        referenceNames: [],
        working: false,
      }
    },
    methods: {
        //inspired from vue-laravel-crud

    //POINTS CRUD NEED READ ONLY
        //methods other than read() are useless, but kept for the moment until I can remove them and not break anything in the process.
        create() {
            this.mute = true;
            
            window.axios.get('/api/points/create').then(({ data }) => {
            this.points.push(new Point(data));
            this.mute = false;
            });
            window.axios.get('/api/languages/create').then(({ data }) => {
            this.languages.push(new Language(data));
            this.mute = false;
            });
            window.axios.get('/api/categories/create').then(({ data }) => {
            this.categories.push(new Category(data));
            this.mute = false;
            });
            window.axios.get('/api/references/create').then(({ data }) => {
            this.references.push(new Reference(data));
            this.mute = false;
            });
        },
        readPoints() {
            this.mute = true;
            window.axios.get('/api/points').then(({ data }) => {
            data.forEach(point => {
                //loops over each point in db
                console.log("point :");
                console.log(point);
                this.points.push(new Point(point));
                
            });
            this.mute = false;
            });
        },
        update(id, color) {
            this.mute = true;
            window.axios.put(`/api/points/${id}`, { color }).then(() => {
            this.points.find(point => point.id === id).color = color;
            this.mute = false;
            });
        },
        del(id) {
            this.mute = true;
            window.axios.delete(`/api/points/${id}`).then(() => {
            let index = this.points.findIndex(point => point.id === id);
            this.points.splice(index, 1);
            this.mute = false;
            });
        },
    //REFERENCES READ
        readReferences() {
            this.mute = true;
            window.axios.get('/api/references').then(({ data }) => {
            data.forEach(reference => {
                //loops over each reference in db
                console.log("reference :");
                console.log(reference);
                this.references.push(new Reference(reference));
                
            });
            this.mute = false;
            });
        },
    //REFERENCE NAMES READ
        readReferenceName() {
            this.mute = true;
            console.log(window.axios.get('/api/referenceNames'));
            
            window.axios.get('/api/referenceNames').then(({ data }) => {
            data.forEach(referenceName => {
                //loops over each language in db
                console.log("referenceName :");
                console.log(referenceName);
                this.referenceNames.push(new ReferenceName(referenceName));
                
            });
            this.mute = false;
            });
        },
    //CATEGORIES READ
        readCategories() {
            this.mute = true;
            window.axios.get('/api/categories').then(({ data }) => {
            data.forEach(category => {
                //loops over each category in db
                console.log("category :");
                console.log(category);
                this.categories.push(new Category(category));
            });
            this.mute = false;
            });
        },
    //LANGUAGES READ
        readLanguages() {
            this.mute = true;
            window.axios.get('/api/languages').then(({ data }) => {
            data.forEach(language => {
                //loops over each language in db
                console.log("language :");
                console.log(language);
                this.languages.push(new Language(language));
                
            });
            this.mute = false;
            });
        },
    },
    computed: {
    // function
      functionName: function() {

      }
    },
    created() {
        this.readPoints();
        this.readReferences();
        this.readReferenceName();
        this.readLanguages();
        this.readCategories();
        console.log("points"); 
        console.log(this.points); 
        console.log("references"); 
        console.log(this.references); 
        console.log("referenceNames"); 
        console.log(this.referenceNames); 
        console.log("categories"); 
        console.log(this.categories); 
        console.log("languages"); 
        console.log(this.languages); 
    },
    components: {
        MapControls,
        PointListComponent
    }
  }
</script>

<style scoped>
    .noPaddingLeft{
        margin-left: -15% !important;
    }
    .buttonContact{
        height: 60px;
        width: 100px;
        position: absolute;
        right: 0;
        bottom: 0;
        z-index: 1;
    }
    .buttonContact > button{
        right: 5px;
    }

  /* #publicMapControls{
    float: right;
    border: 5px;
    border-color: brown;
    border-style: solid;
    z-index: 100;
  } */

    .linkColor{
        color: rgb(230, 230, 103);
    }
</style>