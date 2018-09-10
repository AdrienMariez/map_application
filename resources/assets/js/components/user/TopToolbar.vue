<template>
        <!-- top header -->
        <v-toolbar
            id="toolbar"
            color="white"
            fixed
            app
            dense>
            <v-layout align-center justify-space-around fill-height>
                <v-flex>
                    <v-layout align-center fill-height>
                    <!-- show the menu if hidden -->
                        <v-toolbar-side-icon
                            v-if="!drawer"
                            @click.stop="drawerLocal = !drawerLocal"
                            color="green lighten-1"
                            class="white--text">
                        </v-toolbar-side-icon>

                    <!-- logo Prayssac -->
                        <v-layout
                            align-center
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
                <v-flex>
                    <v-layout align-center justify-end row fill-height>
                    <!-- select language -->
                        <v-select
                            :items="languages"
                            prepend-icon="map"
                            v-model="languageSelectedLocal"
                            align-center
                            single-line
                            class="mr-3 input-group--focused selectTop"
                            item-value=code
                            item-text=name
                        >
                        </v-select>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-toolbar>
</template>

<script>
    import languagesMethods from './../../services/languages.js'

  export default {
    props: ['languageSelected','drawer','mini'],
    data () {
      return {
        drawerLocal: true,
        languages: [],
        languageSelectedLocal: '',
        working: false,
        actionSender: false,
      }
    },
    watch: {
        languageSelected(val, oldVal) {
            this.languageSelectedLocal = val;
        },
        drawer(val, oldVal) {
            this.drawerLocal = val;
        },
        languageSelectedLocal(val, oldVal) {
            this.emitLanguage();
        },
        drawerLocal(val, oldVal) {
            this.emitDrawer();
        },
    },
    methods: {
        //DRAWER EMIT
            emitDrawer() {
                this.$emit('emitDrawer', this.drawerLocal);
            },
        //ON LANGUAGE SELECT EMIT LANGUAGE
            emitLanguage(){
                this.$emit('emitLanguageSelected', this.languageSelectedLocal);
            },
        //
        //API CALLS
            methodsApiCalls() {
                this.languages = languagesMethods.readActiveLanguages();
            },            
    },
    created() {
        this.methodsApiCalls();
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
</style>