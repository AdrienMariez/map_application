<template>
    <div>
    <!-- Main aside -->
        <v-navigation-drawer
            v-model="drawer"
            :mini-variant="mini"
            color="white"
            class="white asideDrawer"
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
                    color="green lighten-3"
                    class="green lighten-3"
                    :class="{ listColorAlt: i % 2 == 0 }">

                    <!-- header -->
                    <div 
                        slot="header"
                        class="pl-0">
                        <v-list>
                            <v-list-tile>
                                <v-list-tile-action>
                                    <!-- class="shadow" -->
                                    <v-icon
                                        large
                                        v-bind:style="{ color: category.color }">
                                        {{category.icon}}
                                    </v-icon>
                                </v-list-tile-action>
                                <v-list-tile-action v-if="!mini">
                                    <!-- loop on names in categories & translations -->
                                    <v-list-tile-content
                                        v-for="(catName,a) in categoriesNames"
                                        v-if="catName.fk_language_code == languageSelected && catName.fk_category_id == category.id"
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
                        class="pt-0 pb-0">
                        <v-list-tile
                            v-for="(reference,y) in references"
                            v-if="reference.fk_category_id == category.id"
                            :key="y"
                            @click.stop="displayReferencePoints(reference.id, category.color)"
                            class="refListElement">
                            <!-- <div class="borderReferences"></div> -->
                            <v-list-tile-action>
                                <!-- class="shadow" -->
                                <v-icon
                                    large
                                    v-bind:style="{ color: category.color }">
                                    {{reference.icon}}
                                </v-icon>
                            </v-list-tile-action>
                            <v-list-tile-action>
                                <!-- loop on names in references & translations -->
                                <v-list-tile-content
                                    v-for="(refName,b) in referenceNames"
                                    v-if="refName.fk_language_code == languageSelected && refName.fk_reference_id == reference.id"
                                    :key="b">
                                    {{refName.text}}
                                </v-list-tile-content>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>

                    </v-expansion-panel-content>
                </v-expansion-panel>
            <!-- NAVIGATION MENU -->

        </v-navigation-drawer>

    <!-- Top header -->
        <top-toolbar
            v-bind:languageSelected="languageSelected"
            v-bind:drawer="drawer"
            v-bind:mini="mini"
            @emitLanguageSelected="emitLanguageSelected"
            @emitDrawer="emitDrawer">
        </top-toolbar>


    </div>
</template>

<script>
import TopToolbar from './TopToolbar.vue'
import ContactForm from './ContactForm.vue'
import pointsMethods from './../../services/points.js'
import referencesMethods from './../../services/references.js'
import categoriesMethods from './../../services/categories.js'
import languagesMethods from './../../services/languages.js'

export default {
    props: ['localStoragePointsDisplayed'],
    data () {
      return {
        drawer: true,
        mini: false,
        showAllForms: null,
        points: [],
        languages: [],
        languageSelected: '',
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
        languages(val, oldVal){
            this.lookForUserLanguage();
        },
        languageSelected(val, oldVal) {
            this.languageSelected = val
            this.emitLanguage();
            this.$i18n.locale = this.languageSelected
        },
        localStoragePointsDisplayed(val, oldVal){
            this.referenceDisplayed = val;
        }
    },
    methods: {
        //ON START FIND OUT THE USER BROWSER LANGUAGE
            lookForUserLanguage() {
                if (localStorage.getItem("languageSelected") !== null){
                    var localLanguage = localStorage.getItem("languageSelected");
                    
                    this.languageSelected = localLanguage;
                }
                else{
                    //HOW TO
                        //https://stackoverflow.com/questions/1043339/javascript-for-detecting-browser-language-preference
                        // console.log(navigator.language);
                        //is FireFox and all other browser.
                        // console.log(window.navigator.userLanguage);
                        //is IE only and it's the language set in Windows Control Panel - Regional Options and NOT browser language
                        // https://en.wikipedia.org/wiki/Language_localisation
                    //END HOW TO
                    var languageCode = window.navigator.userLanguage || window.navigator.language;
                    // var languageCode = "de-AT";
                    var language = languageCode.substring(0,2);
                    var languages = JSON.parse(JSON.stringify(this.languages));
                    
                    var languageSelected = null;
                    var languageEnglish = null;

                    languages.forEach(lang => {
                        if (lang["code"] == language) {
                            // console.log("language recognized : "+lang["code"]);
                            languageSelected = lang["code"];
                        }
                        if (lang["code"] == "en") {
                            languageEnglish = lang["code"];
                            // console.log("english found");
                        }
                    });
                    if (languageSelected == null) {
                        // console.log("language not recognized ! Set in english by default !");  
                        languageSelected = languageEnglish;
                    }
                    
                    this.languageSelected = languageSelected;
                    this.$locale = this.languageSelected
                }
                // $i18n.locale = this.languageSelected
                this.$i18n.locale = this.languageSelected
                // this.$locale = this.languageSelected    
                // this.$root.i18n.locale  = this.languageSelected
            },
        //DRAWER EMIT
            emitDrawer(newDrawer){
                this.drawer = newDrawer;
            },
            drawerMethod() {
                this.$emit('drawerMethod', this.drawer);
            },
        //ON POINT CLICK EMIT NEW REFERENCES TO DISPLAY/HIDE
            displayReferencePoints(refId, catColor){
                //loop over the table as the order isn't by id, or else we end up with the wrong categories and errors in the point display mechanic

                var referenceDisplayed = JSON.parse(JSON.stringify(this.referenceDisplayed));
                
                for (let i = 0; i < referenceDisplayed.length; i++) {
                    if (referenceDisplayed[i]["id"] == refId) {
                        if (referenceDisplayed[i]["isToBeDisplayed"] == true){
                            referenceDisplayed[i]["isToBeDisplayed"] = false;
                        }
                        else{
                            referenceDisplayed[i]["isToBeDisplayed"] = true;
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
                        referenceDisplayed[i]["catColor"] = color;
                    }
                }

                this.actionSender = !this.actionSender;
                this.$emit('displayPoints', referenceDisplayed, this.actionSender);
                this.referenceDisplayed = referenceDisplayed;
                localStorage.setItem('referencesDisplayed', JSON.stringify(referenceDisplayed));
            },
        //ON LANGUAGE SELECT EMIT LANGUAGE
            emitLanguageSelected(newLanguage){
                this.languageSelected = newLanguage;
            },
            emitLanguage(){
                var referenceDisplayed = JSON.parse(JSON.stringify(this.referenceDisplayed));
                for (let i = 0; i < referenceDisplayed.length; i++) {
                    if (referenceDisplayed[i]["isToBeDisplayed"] == true){
                        referenceDisplayed[i]["isToBeDisplayed"] = false;
                    }
                }
                this.actionSender = !this.actionSender;
                
                this.$emit('displayPoints', referenceDisplayed, this.actionSender);
                this.$emit('emitLanguage', this.languageSelected);
                this.referenceDisplayed = referenceDisplayed;
                var languageSelected = JSON.parse(JSON.stringify(this.languageSelected));
                localStorage.setItem('languageSelected', languageSelected);
                
            },
        //
        //API CALLS
            methodsApiCalls() {
                this.categories = categoriesMethods.readCategories();
                this.categoriesNames = categoriesMethods.readCategoriesNames();
                this.references = referencesMethods.readReferences();
                this.referenceNames = referencesMethods.readReferenceNames();
                this.points = pointsMethods.readPoints();
                this.languages = languagesMethods.readLanguages();
            },
    },
    created() {
        this.methodsApiCalls();
    },
    components: {
        TopToolbar,
        ContactForm,
    }
  }
</script>

<style scoped>
    .asideDrawer{
        max-height: 100% !important;
    }
    .v-list__tile__action--stack{
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        white-space: unset !important;
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

    .listColorAlt{
        background-color: #C8E6C9 !important;
    }
    .refListElement:nth-child(odd) {
        background-color: #F0F4C3;
    }
    .refListElement:nth-child(even) {
        background-color: #F9FBE7;
    }

    /* .borderReferences{
        content:'';
        position:absolute;
        width:100%;
        height:3px;
        background:linear-gradient(to left, rgba(0, 0, 0, 0), #C8E6C9);
        top:0px;
        left:0;
    } */

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