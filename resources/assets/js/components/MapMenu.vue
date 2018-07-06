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
            <v-expansion-panel
                expand>
                <!-- loop on categories -->
                <v-expansion-panel-content
                v-for="(item,i) in 5"
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
                                <v-list-tile-content v-if="fr">
                                    Categorie {{i}}
                                </v-list-tile-content>
                                <v-list-tile-content v-if="!fr">
                                    Category {{i}}
                                </v-list-tile-content>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                </div>


                <!-- <v-list
                    slot="header"
                    class="pt-0 noPaddingLeft">
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-icon large color="blue darken-2">
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
                </v-list> -->

                <!-- loop on references in categories -->
                <v-list
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
            </v-expansion-panel>
            <!-- // END DUMMY NAV  -->

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

import MapControls from './MapControls.vue'
  export default {
    data () {
      return {
        drawer: true,
        mini: false,
        fr: true,
      }
    },
    computed: {
    // function
      functionName: function() {

      }
    },
    components: {
        MapControls,
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