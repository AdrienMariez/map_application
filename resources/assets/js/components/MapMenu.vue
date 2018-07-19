<template>
    <div>
        <!-- Prayssac_logo.png -->

        <!-- <map-controls></map-controls> -->

        <v-navigation-drawer
            v-model="drawer"
            :mini-variant="mini"
            color="white"
            class="white"
            app>

            <!-- deploy full nav when miniaturized -->
            <v-list-tile v-if="mini" @click.stop="mini = !mini">
                <v-list-tile-action class="cursorAction">
                    <v-icon>chevron_right</v-icon>
                </v-list-tile-action>
            </v-list-tile>

            <!-- top menu when deployed -->
            <v-list-tile v-if="!mini">
                <v-layout row wrap justify-center>
                <!-- fold full nav -->
                    <v-flex xs4>
                        <v-list-tile-action
                            text-xs-center
                            align-center
                            justify-center
                            @click.stop="mini = !mini"
                            class="text-xs-center flexCenter cursorAction">
                            <v-icon>
                                chevron_left
                            </v-icon>
                        </v-list-tile-action>
                    </v-flex>
                <!-- logo Prayssac responsive -->
                    <v-flex xs4 align-center>
                        <v-list-tile-action
                            text-xs-center
                            align-center
                            justify-center
                            v-if="!mini"
                            class="text-xs-center flexCenter logoContainerMini hidden-md-and-up">
                                <img :src="'/images/Prayssac_logo.png'" >
                        </v-list-tile-action>
                    </v-flex>
                <!-- close full nav -->
                    <v-flex xs4 align-center>
                        <v-list-tile-action
                            text-xs-center
                            align-center
                            justify-center
                            v-on:click="drawerMethod()"
                            @click.stop="drawer = !drawer"
                            class="text-xs-center flexCenter cursorAction">
                            <v-icon>
                                close
                            </v-icon>
                        </v-list-tile-action>
                    </v-flex>
                </v-layout>
            </v-list-tile>

            <v-divider></v-divider>

            <v-spacer></v-spacer>

            <!-- OBSOLETE language switch -->
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
            <!-- END OBSOLETE language switch -->

            <!-- sends back the current language id -->
            <!-- <div>{{ languageSelected }}</div> -->
            
            <!-- logo Prayssac desktop -->
                <div
                    v-if="!mini"
                    class="mx-5 logoContainer hidden-sm-and-down">
                    <img :src="'/images/Prayssac_logo.png'" >
                </div>
            <!-- END logo Prayssac responsive -->

            <!-- NAVIGATION MENU -->
                <v-expansion-panel
                    expand>
                    <!-- loop on categories -->
                    <v-expansion-panel-content
                    v-for="(category,i) in categories"
                    :key="i"
                    :value="showAllForms"
                    @click.stop="showAllForms = null"
                    color="green lighten-4"
                    class="green lighten-4">

                    <!-- header -->
                    <div 
                        slot="header">
                        <v-list class="noPaddingLeft">
                            <v-list-tile>
                                <v-list-tile-action>
                                    <!-- class="shadow" -->
                                    <v-icon
                                        large
                                        v-bind:style="{ color: category.color }">
                                        fa-{{category.icon}}
                                    </v-icon>
                                </v-list-tile-action>
                                <v-list-tile-action>
                                    <!-- loop on names in categories & translations -->
                                    <v-list-tile-content
                                        v-for="(catName,a) in categoriesNames"
                                        v-if="catName.fk_language_id == languageSelected && catName.fk_category_id == category.id"
                                        :key="a">
                                        <!-- {{catName.fk_category_id}} -  -->
                                        {{catName.text}}
                                    </v-list-tile-content>
                                    <!-- OBSOLETE old language switch -->
                                        <!-- <v-list-tile-content v-if="fr">
                                            {{category.icon}} - {{category.weight}}
                                        </v-list-tile-content>
                                        <v-list-tile-content v-if="!fr">
                                            {{category.color}} - {{category.weight}}
                                        </v-list-tile-content> -->
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </div>

                    <!-- loop on references in categories -->
                    <v-list
                        class="pt-0 white"
                        v-for="(reference,y) in references"
                        v-if="reference.fk_category_id == category.id"
                        :key="y"
                        color="white">
                        <v-list-tile @click.stop="displayReferencePoints(reference.id, category.color)">
                            <v-list-tile-action>
                                <!-- class="shadow" -->
                                <v-icon
                                    large
                                    v-bind:style="{ color: category.color }">
                                    fa-{{reference.icon}}
                                </v-icon>
                            </v-list-tile-action>
                            <v-list-tile-action>
                                <!-- loop on names in references & translations -->
                                <v-list-tile-content
                                    v-for="(refName,b) in referenceNames"
                                    v-if="refName.fk_language_id == languageSelected && refName.fk_reference_id == reference.id"
                                    :key="b">
                                    {{refName.fk_reference_id}} - 
                                    {{refName.text}}
                                </v-list-tile-content>
                                <!-- OBSOLETE old language switch -->
                                    <!-- <v-list-tile-content v-if="fr">
                                        {{reference.icon}} - {{reference.weight}}
                                    </v-list-tile-content>
                                    <v-list-tile-content v-if="!fr">
                                        {{reference.id}} - {{reference.weight}}
                                    </v-list-tile-content> -->
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>

                    </v-expansion-panel-content>
                </v-expansion-panel>
            <!-- NAVIGATION MENU -->

            <!-- OBSOLETE TEST NAV -->
                <!-- <point-list-component
                    v-for="category in categories"
                    v-bind="category"
                    :key="category.id"
                    @update="update"
                    @delete="del"
                >
                </point-list-component> -->
            <!-- END OBSOLETE TEST NAV -->

        </v-navigation-drawer>

        <!-- top header -->
        <v-toolbar
            id="toolbar"
            color="white"
            fixed
            app
            dense>
            <v-layout align-center justify-space-around row fill-height>
                <v-flex>
                    <v-layout align-center row fill-height>
                    <!-- show the menu if hidden -->
                        <v-toolbar-side-icon
                            v-if="!drawer"
                            v-on:click="drawerMethod()"
                            @click.stop="drawer = !drawer"
                            color="green lighten-1"
                            class="white--text">
                        </v-toolbar-side-icon>

                    <!-- logo Prayssac -->
                        <v-layout
                            align-center
                            row
                            v-if="!drawer || mini"
                            class="logoContainerMini">
                            <img :src="'/images/Prayssac_logo.png'" >
                            <v-toolbar-title
                                class="hidden-xs-only">
                                Carte interactive de Prayssac
                            </v-toolbar-title>
                        </v-layout>
                    </v-layout>
                </v-flex>

                <!-- title -->
                <!-- <v-flex>
                <v-toolbar-title>
                    Carte interactive de Prayssac
                </v-toolbar-title>
                </v-flex> -->
            
                <!-- logo Prayssac -->
                <!-- <v-flex>
                    <div
                        v-if="!drawer"
                        class="logoContainerMini">
                        <img :src="'/images/Prayssac_logo.png'" >
                    </div>
                </v-flex> -->

                <v-flex>
                    <v-layout align-center justify-end row fill-height>
                    <!-- select language -->
                        <v-select
                            :items="languages"
                            prepend-icon="map"
                            v-model="languageSelected"
                            align-center
                            single-line
                            class="mr-3 input-group--focused selectTop"
                            item-value=id
                            item-text=name
                        >
                        </v-select>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-toolbar>

        <!-- contact button -->
        <!-- <v-card-text class="buttonContact">
            <v-btn
                absolute
                dark
                center
                color="green lighten-1"
            >
                <div class="linkColor">Contact</div>
            </v-btn>
        </v-card-text> -->


        <contact-form v-if="languageSelected == 0" class="buttonContact"></contact-form>

        <contact-form-en v-if="languageSelected == 1" class="buttonContact"></contact-form-en>

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
    //END Needed for promises to work
    // import MapControls from './MapControls.vue'
    // import PointListComponent from './PointList.vue';

  import ContactForm from './ContactForm.vue'
  import ContactFormEn from './ContactFormEn.vue'

  export default {
    data () {
      return {
        drawer: true,
        mini: false,
        showAllForms: null,
        points: [],
        languages: [],
        languageSelected: 0,
        categories: [],
        categoriesNames: [],
        references: [],
        referenceNames: [],
        referenceDisplayed: [],
        working: false,
        actionSender: false,
      }
    },
    watch: {
        languageSelected(val, oldVal) {
            this.languageSelected = val
            this.emitLanguage();
        }
    },
    methods: {
        drawerMethod() {
            this.$emit('drawerMethod', this.drawer);
        },
        displayReferencePoints(refId, catColor){
            //loop over the table as the order isn't by id, or else we end up with the wrong categories and errors in the point display mechanic
            for (let i = 0; i < this.referenceDisplayed.length; i++) {
                if (this.referenceDisplayed[i]["id"] == refId) {
                    if (this.referenceDisplayed[i]["isToBeDisplayed"] == true){
                        this.referenceDisplayed[i]["isToBeDisplayed"] = false;
                    }
                    else{
                        this.referenceDisplayed[i]["isToBeDisplayed"] = true;
                    }
                    //convert colors for the icons
                    var color;
                    switch (catColor) {
                        case "#B71C1C":
                            //red darken-4
                            color = "red";
                            break;

                        case "#F4511E":
                            //deep-orange darken-4
                            color = "orange-dark";
                            break;

                        case "#FFA726":
                            //orange lighten-1
                            color = "orange";
                            break;

                        case "#FFC400":
                            //amber accent-3
                            color = "yellow";
                            break;

                        case "#006064":
                            //cyan darken-4
                            color = "blue-dark";
                            break;

                        case "#01579B":
                            //light-blue darken-4
                            color = "blue";
                            break;

                        case "#1E88E5":
                            //blue darken-1
                            color = "cyan";
                            break;

                        case "#4A148C":
                            //purple darken-4
                            color = "purple";
                            break;

                        case "#880E4F":
                            //pink darken-4
                            color = "violet";
                            break;

                        case "#F50057":
                            //pink accent-3
                            color = "pink";
                            break;

                        case "#1B5E20":
                            //green darken-4
                            color = "green-dark";
                            break;

                        case "#388E3C":
                            //green darken-2
                            color = "green";
                            break;

                        case "#4CAF50":
                            //green
                            color = "green-light";
                            break;

                        default:
                            color = catColor;
                    }
                    this.referenceDisplayed[i]["catColor"] = color;
                }
            }

            this.actionSender = !this.actionSender;
            this.$emit('displayPoints', this.referenceDisplayed, this.actionSender);
        },
        emitLanguage(){
            for (let i = 0; i < this.referenceDisplayed.length; i++) {
                if (this.referenceDisplayed[i]["isToBeDisplayed"] == true){
                    this.referenceDisplayed[i]["isToBeDisplayed"] = false;
                }
            }
            this.actionSender = !this.actionSender;
            
            this.$emit('emitLanguage', this.languageSelected);
            this.$emit('displayPoints', this.referenceDisplayed, this.actionSender);
        },
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
                    var obj = {};
                    obj["id"] = reference.id;
                    obj["isToBeDisplayed"] = false;
                    obj["catColor"] = "";
                    this.referenceDisplayed.push(obj);
                    // this.referenceDisplayed.push(false);
                });
                this.mute = false;
                });
            },
        //REFERENCE NAMES READ
            readReferenceNames() {
                this.mute = true;
                window.axios.get('/api/referencesnames').then(({ data }) => {
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
                window.axios.get('/api/categoriesnames').then(({ data }) => {
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
        // The table is emitted at initialization so the map can work directly.
        // this.$emit('displayPoints', this.referenceDisplayed);
        // this.$emit('displayPoints', this.referenceDisplayed);
        //logs for api returns
            // console.log("points"); 
            // console.log(this.points); 
            // console.log("references"); 
            // console.log(this.references); 
            // console.log("referencenames"); 
            // console.log(this.referenceNames); 
            // console.log("referencedisplayed"); 
            // console.log(this.referenceDisplayed); 
            // console.log("categories"); 
            // console.log(this.categories); 
            // console.log("categoriesnames"); 
            // console.log(this.categoriesNames); 
            // console.log("languages :"); 
            // console.log(this.languages); 
            // console.log("language selected :"); 
            // console.log(this.languageSelected);
    },
    components: {
        // MapControls,
        // PointListComponent,
        ContactForm,
        ContactFormEn
    }
  }
</script>

<style scoped>
    .noPaddingLeft{
        margin-left: -15% !important;
    }
    .selectTop{
        z-index: 200;
        max-width: 100px;
        margin-top: 10px;
    }
    /* .shadow{
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
    } */
    .logoContainer > img{
        width: 200px;
        height: 200px;
    }
    .logoContainerMedium > img{
        width: 80px;
        height: 80px;
    }
    .logoContainerMini{
        height: 100%;
    }
    .logoContainerMini > img{
        width: 48px;
        height: 48px;
    }
    .flexCenter {
        justify-content: center;
    }
    .cursorAction{
        cursor: pointer;
    }
    a{
        color: rgb(24, 53, 17) !important;
        text-decoration: inherit;
    }
  /* #publicMapControls{
    float: right;
    border: 5px;
    border-color: brown;
    border-style: solid;
    z-index: 100;
  } */
</style>