<template>
    <div>
        <!-- top header -->
        <v-card
            xs12>
            <v-layout row justify-space-around>
                <v-flex xs12 sm10>
                    <v-card-title class="width90">
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

                        <v-layout row>
                            <v-flex>
                                <v-layout
                                    justify-end
                                    row>
                                    <v-menu
                                        bottom
                                        left>
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
                                                <v-icon class="hidden-sm-and-down pa-2">
                                                    {{ link.icon }}
                                                </v-icon>
                                                <v-list-tile-title>
                                                    {{ link.title }}
                                                </v-list-tile-title>
                                            </v-list-tile>
                                        </v-list>
                                    </v-menu>

                                    <!-- <v-menu
                                        bottom
                                        left>
                                        <v-btn
                                            slot="activator"
                                            icon
                                            large
                                            class="hidden-md-and-up">
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

                                    <v-menu
                                        bottom
                                        left>
                                                                                                                    <v-btn
                                            slot="activator"
                                            class="hidden-sm-and-down">
                                            menu
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
                                    </v-menu> -->

                                    <!-- <v-layout
                                        row
                                        justify-end
                                        class="hidden-sm-and-down">
                                        <v-flex>
                                            <v-toolbar-items 
                                                color="transparent"
                                                class="transparent">
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
                                        </v-flex>
                                    </v-layout> -->
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
        links: [
            { title: "Retour à la carte", page: "public", icon: "map" },
            { title: "Retourner au menu d'administration principal", page: "admin", icon: "list" },
            { title: "Arrangement des listes", page: "sort", icon: "swap_vert" },
            { title: "Administration des langues", page: "languages", icon: "language" },
            { title: "Messages reçus", page: "contact", icon: "chat_bubble_outline" },
            { title: "Se déconnecter", page: "logout", icon: "fa-power-off" }
        ]
      }
    },
    methods: {
        //REDIRECTION
            redirect(link){
                this.$router.push({ name: link })
                this.$emit('pageToShow', "", null);
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
  }
</script>

<style scoped>
    .width90{
        width: 90vw;
    }
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