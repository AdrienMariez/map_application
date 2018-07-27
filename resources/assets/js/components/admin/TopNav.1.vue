<template>
    <div>
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
                    <!-- logo Prayssac -->
                        <v-layout
                            align-center
                            row
                            class="logoContainerMini">
                            <img :src="'/images/Prayssac_logo.png'" >
                            <v-toolbar-title
                                class="hidden-xs-only">
                                Carte interactive de Prayssac
                            </v-toolbar-title>
                        </v-layout>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-toolbar>
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