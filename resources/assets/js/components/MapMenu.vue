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
                <!-- old -->
                <!-- <v-list-tile @click.stop="fr = !fr">
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
                </v-list-tile> -->

            <!-- Ok this cooooould get some improvements...FIX IT ASAP THE V-SELECT FRONT WON'T WORK -->
            <!-- <v-select
                :items="languages"
                v-model="languageSelected"
                label="Langage"
                class="input-group--focused"
                item-value=id
                item-text=id
            >
            </v-select> -->
            <div>{{ languageSelected }}</div>

            <!-- // NOT SO DUMMY NAV  -->
            <v-expansion-panel
                expand>
                <!-- loop on categories -->
                <v-expansion-panel-content
                v-for="(category,i) in categories"
                :key="i"
                color="green darken-3"
                class="green darken-3">

                <!-- header -->
                <div 
                    slot="header">
                    <v-list class="noPaddingLeft">
                        <v-list-tile>
                            <v-list-tile-action>
                                <v-icon large color="brown lighten-4">
                                    home
                                </v-icon>
                            </v-list-tile-action>
                            <v-list-tile-action>
                                <!-- TO CHANGE uncomment this -->
                                <!-- <v-list-tile-content
                                    v-for="(categoryname,x) in categoriesNames"
                                    :key="x">
                                    <div v-if="categoryname.fk_language_id == languageSelected">
                                        {{categoryname.text}}
                                    </div>
                                </v-list-tile-content> -->

                                <v-list-tile-content v-if="fr">
                                    {{category.color}}
                                </v-list-tile-content>
                                <v-list-tile-content v-if="!fr">
                                    {{category.icon}}
                                </v-list-tile-content>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                </div>

                <!-- loop on references in categories -->
                <v-list
                    class="pt-0"
                    v-for="(reference,y) in references"
                    :key="y">
                    <v-list-tile v-if="reference.fk_category_id == category.id">
                        <v-list-tile-action>
                            <v-icon color="blue darken-2">
                                grade
                            </v-icon>
                        </v-list-tile-action>
                        <v-list-tile-action>
                            <v-list-tile-content v-if="fr">
                                {{reference.icon}}
                            </v-list-tile-content>
                            <v-list-tile-content v-if="!fr">
                                {{reference.id}}
                            </v-list-tile-content>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>

                </v-expansion-panel-content>
            </v-expansion-panel>
            <!-- // END NOT SO DUMMY NAV  -->

            <!-- TEST NAV -->
                <!-- <point-list-component
                    v-for="category in categories"
                    v-bind="category"
                    :key="category.id"
                    @update="update"
                    @delete="del"
                >
                </point-list-component> -->
            <!-- END TEST NAV -->

        </v-navigation-drawer>

        <!-- top header -->
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
            <v-select
                :items="languages"
                v-model="languageSelected"
                class="input-group--focused selectTop"
                item-value=id
                item-text=name
            >
            </v-select>
        </v-toolbar>

        <!-- contact button -->
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

//Needed for promises to work
    function Language({ id, name}) {
        this.id = id;
        this.name = name;
    }
    function Category({ id, icon, color, weight}) {
        this.id = id;
        this.icon = icon;
        this.color = color;
        this.weight = weight;
    }
    function CategoryName({ id, fk_category_id, fk_language_id, text}) {
        this.id = id;
        this.fk_category_id = fk_category_id;
        this.fk_language_id = fk_language_id;
        this.text = text;
    }
    function Reference({ id, icon, color, weight, fk_category_id}) {
        this.id = id;
        this.icon = icon;
        this.color = color;
        this.weight = weight;
        this.fk_category_id = fk_category_id;
    }
    function ReferenceName({ id, fk_reference_id, fk_language_id, text}) {
        this.id = id;
        this.fk_reference_id = fk_reference_id;
        this.fk_language_id = fk_language_id;
        this.text = text;
    }
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
        // TO CHANGE : languageSelected basic value should be 1- french OR 2- client language. If 1-, set to 0,if 2-,ask google how.
        languageSelected: 1,
        categories: [],
        categoriesNames: [],
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
                // console.log("point :");
                // console.log(point);
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
                // console.log("reference :");
                // console.log(reference);
                this.references.push(new Reference(reference));
                
            });
            this.mute = false;
            });
        },
    //REFERENCE NAMES READ
        readReferenceNames() {
            this.mute = true;
            window.axios.get('/api/referencesNames').then(({ data }) => {
            data.forEach(referenceName => {
                //loops over each reference name in db
                // console.log("reference name :");
                // console.log(referenceName);
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
                // console.log("category :");
                // console.log(category);
                this.categories.push(new Category(category));
            });
            this.mute = false;
            });
        },
    //CATEGORIES NAMES READ
        readCategoriesNames() {
            this.mute = true;
            window.axios.get('/api/categoriesNames').then(({ data }) => {
            data.forEach(categoryName => {
                //loops over each category name in db
                // console.log("category name :");
                // console.log(categoryName);
                this.categoriesNames.push(new CategoryName(categoryName));
                
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
                // console.log("language :");
                // console.log(language);
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
        //each line calls for the function responsible for the api returns
        this.readReferenceNames();
        this.readPoints();
        this.readReferences();
        this.readCategories();
        this.readLanguages();
        this.readCategoriesNames();
        //logs for api returns
            // console.log("points"); 
            // console.log(this.points); 
            // console.log("references"); 
            // console.log(this.references); 
            // console.log("referencenames"); 
            // console.log(this.referenceNames); 
            // console.log("categories"); 
            // console.log(this.categories); 
            // console.log("categoriesnames"); 
            // console.log(this.categoriesNames); 
            console.log("languages :"); 
            console.log(this.languages); 
            console.log("language selected :"); 
            console.log(this.languageSelected);
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
    .selectTop{
        z-index: 200;
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