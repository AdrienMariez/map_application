<template>
    <div>
        <v-list two-line>
            <v-subheader>
                Langues implémentées (cliquer pour mettre à jour):
            </v-subheader>
            <v-divider></v-divider>
            <template v-for="(language,i) in languages">
                <v-list-tile
                    :key="i"
                    avatar
                    @click="dummy()">
                    <v-list-tile-content @click="updateLanguage(i)">
                        <v-list-tile-title v-html="language.name"></v-list-tile-title>
                        <v-list-tile-sub-title v-html="language.code"></v-list-tile-sub-title>
                    </v-list-tile-content>
                    <!-- <v-list-tile-avatar @click="deleteLanguage(i)">
                        <v-icon>
                            map
                        </v-icon>
                    </v-list-tile-avatar> -->
                    <v-btn
                        dark
                        fab
                        color="error"
                        @click="deleteLanguage(i)">
                        <v-icon>delete</v-icon>
                    </v-btn>
                </v-list-tile>
            </template>
        </v-list>
        <v-form
            v-if="selectedId !== null"
            ref="form"
            v-model="valid"
            lazy-validation>
            <v-subheader>
                Edition :
            </v-subheader>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 class="my-5">
                            <div>Nom de la langue : </div>
                            <v-text-field
                                v-model=selectedName
                                value= selectedName
                                :counter="30"
                                class="mb-2"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12 class="my-5">
                            <div>Code linguistique : </div>
                            <v-text-field
                                v-model=selectedCode
                                value= selectedCode
                                :counter="2"
                                class="mb-2"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
        </v-form>
    </div>
</template>

<script>
    import languagesMethods from './../../services/languages.js'
        export default {
        data () {
            return {
                languages: [],
                selectedId: null,
                selectedName: "",
                selectedCode: "",

                valid: false,
            }
        },
        watch: {
        },
        methods: {
            dummy() {

            },
            updateLanguage(id) {
                
                // var languages = JSON.parse(JSON.stringify(this.languages));

                this.selectedId = id;
                for (let lang = 0; lang < this.languages.length; lang++) {
                    if (this.languages[lang]["id"] === id) {
                        this.selectedName = this.languages[lang]["name"];
                        this.selectedCode = this.languages[lang]["code"];
                    }
                }
            },
            deleteLanguage(id) {
                console.log("delete "+ id);
            },
            //API CALLS
                methodsApiCalls() {
                    this.languages = languagesMethods.readLanguages();
                },
        },
        created() {
            this.methodsApiCalls();
        },
        components: {
        }
    }
</script>

<style scoped>
</style>