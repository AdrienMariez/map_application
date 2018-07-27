<template>
    <div>
        <!-- top header -->
        <v-card
            xs12>
            <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card-title>
                    <v-layout row>
                        <v-flex>
                            <v-layout
                                align-center
                                row
                                class="logoContainerTopNav">
                                <img
                                    color="transparent"
                                    class="logoMini transparent hidden-md-and-up" :src="'/images/Prayssac_logo.png'" >
                                <img
                                    color="transparent"
                                    class="logoMedium transparent hidden-sm-and-down" :src="'/images/Prayssac_logo.png'" >
                                <v-toolbar-title
                                    class="hidden-xs-only">
                                    Menu d'administration de la carte
                                </v-toolbar-title>
                            </v-layout>
                        </v-flex>
                    </v-layout>
        
                    <v-spacer></v-spacer>

                    <v-layout row>
                        <v-flex>
                            <v-layout
                                align-center
                                row>
                                <v-menu bottom left class="hidden-md-and-up">
                                    <v-btn
                                        slot="activator"
                                        icon
                                        large>
                                        <v-icon>menu</v-icon>
                                    </v-btn>
                        
                                    <v-list>
                                        <v-list-tile
                                        v-for="(link, i) in links"
                                        :key="i"
                                        @click="redirect(link.page)"
                                        >
                                            <v-list-tile-title>
                                                {{ link.title }}
                                            </v-list-tile-title>
                                        </v-list-tile>
                                    </v-list>
                                </v-menu>

                                <v-toolbar-items 
                                    color="transparent"
                                    class="transparent hidden-sm-and-down">
                                    <v-list
                                        color="transparent"
                                        class="transparent">
                                        <v-list-tile
                                        v-for="(link, i) in links"
                                        :key="i"
                                        @click="redirect(link.page)"
                                        >
                                            <v-list-tile-title>
                                                {{ link.title }}
                                            </v-list-tile-title>
                                        </v-list-tile>
                                    </v-list>
                                </v-toolbar-items>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-card-title>
            </v-flex>
            </v-layout>
        </v-card>
    </div>

</template>

<script>
    //Needed for promises to work
        function Language({ id, name, code}) {
            this.id = id;
            this.name = name;
            this.code = code;
        }
    //END Needed for promises to work
    // import MapControls from './MapControls.vue'
    // import PointListComponent from './PointList.vue';


  export default {
    data () {
      return {
        languages: [],
        languageSelected: 0,
        links: [
            { title: "Retour à la carte", page: "map" },
            { title: "Retourner au menu d'administration principal", page: "dashboard" },
            { title: "Se déconnecter", page: "logout" }
        ]
      }
    },
    watch: {
        languages(val, oldVal){
            this.SetAdminLanguage();
        },
        languageSelected(val, oldVal) {
            this.languageSelected = val
            this.emitLanguage();
        }
    },
    methods: {
        //ON START FIND FRENCH LANGUAGE
            SetAdminLanguage() {

                var languageCode = window.navigator.userLanguage || window.navigator.language;
                // var languageCode = "de-AT";
                var language = languageCode.substring(0,2);
                var languages = JSON.parse(JSON.stringify(this.languages));
                var languageFrench = null;
                var languageBackup = null;

                languages.forEach(lang => {   
                        if (lang["code"] == "fr") {
                            languageFrench = lang["id"];
                        }
                        else{
                            languageBackup = lang["id"];
                        }
                });
                if (languageFrench == null) {
                        // if french isn't found, fall back to any other language last created.
                        languageFrench = languageBackup;
                }
                    
                this.languageSelected = languageFrench;
            },

        //Method
            redirect(link){
                console.log(link);
                this.$router.push({ name: link })
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
    created() {
    },
    components: {
    }
  }
</script>

<style scoped>
    .v-card__title{
       padding: 0; 
    }
    .logoContainerTopNav{
        height: 100%;
        flex-direction: column;
    }
    .logoMini{
        width: 48px;
        height: 48px;
    }
    .logoMedium{
        width: 100px;
        height: 100px;
    }
    /* .white--text{
        text-shadow: 2px 2px 8px #000000;
    } */
</style>