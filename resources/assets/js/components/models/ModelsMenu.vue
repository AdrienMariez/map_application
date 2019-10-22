<template>
    <div>
    <!-- Main aside -->
        <v-navigation-drawer
            v-model="drawer"
            color="white"
            class="white asideDrawer"
            app>

            <!-- top menu when deployed -->
            <v-list-tile v-if="!mini">
                <v-layout row wrap justify-center>
                <!-- logo Prayssac responsive -->
                    <v-flex xs6 align-center>
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
                    <v-flex xs6 align-center>
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

            <!-- Model 1 -->
            <div>
                <v-btn
                slot="activator"
                dark
                center
                color="green lighten-1">
                <div class="linkColor">model 01</div>
            </v-btn>
            </div>
            <!-- END Model 1 -->
            <!-- Model 2 -->
                        <div>
                <v-btn
                slot="activator"
                dark
                center
                color="green lighten-1">
                <div class="linkColor">model 02</div>
            </v-btn>
            </div>
            <!-- END Model 2 -->

        </v-navigation-drawer>

    <!-- Top header -->
        <top-toolbar
            v-bind:drawer="drawer"
            v-bind:mini="mini"
            @emitDrawer="emitDrawer">
        </top-toolbar>


    </div>
</template>

<script>
import TopToolbar from './ModelsTopToolbar.vue'

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
    methods: {
        //DRAWER EMIT
            emitDrawer(newDrawer){
                this.drawer = newDrawer;
            },
            drawerMethod() {
                this.$emit('drawerMethod', this.drawer);
            },
    },
    components: {
        TopToolbar,
    }
  }
</script>

<style scoped>
    .asideDrawer{
        max-height: 100% !important;
        max-width: 60%;
        min-width: 180px;
    }
    .v-list{
        padding: 0 !important;
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
    .flexCenter {
        justify-content: center;
    }
    .cursorAction{
        cursor: pointer;
    }
    a{
        color: rgb(146, 221, 123) !important;
        text-decoration: inherit;
    }
</style>