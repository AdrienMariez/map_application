<template>
    <div>
        <div>
            <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 class="my-5">
                                    <div>Nom de la catégorie dans chaque langue : </div>
                                    <v-text-field
                                        v-for="(language,i) in languages"
                                        :key="i"
                                        v-model=names[i]
                                        :rules="nameRules"
                                        :label= language.name
                                        hint="Nom de la catégorie dans chaque langue"
                                        value= names[i]
                                        required
                                        :counter="50"
                                        class="mb-2"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <div>Icone utilisée : </div>
                                    <v-select
                                        label="origine de l'icone :"
                                        item-text="text"
                                        item-value="code"
                                        :items="iconsPrefix"
                                        v-model="selectedPrefix"
                                        required
                                        class="mb-2"
                                    ></v-select>
                                    <v-text-field
                                        v-model="icon"
                                        :rules="iconRules"
                                        label="icone"
                                        hint="icone utilisée par la catégorie"
                                        required
                                        :counter="40"
                                    ></v-text-field>
                                    <div>Aperçu de {{selectedPrefix}}{{icon}} :
                                        <v-icon
                                            v-bind:style="{ color: selectedColor }"
                                            x-large>
                                            {{selectedPrefix}}{{icon}}
                                        </v-icon>
                                    </div>
                                </v-flex>
                                <v-divider></v-divider>
                                <v-flex xs12 class="my-5">
                                    <div>Couleur de l'icone de la catégorie : </div>
                                    <v-select
                                        item-text="text"
                                        item-value="code"
                                        :items="colors"
                                        v-model="selectedColor"
                                        required
                                    ></v-select>
                                    <div id="coloredDiv"></div>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-layout row wrap justify-space-between>
                            <v-flex xs2 align-right>
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-btn
                                            :disabled="!valid"
                                            @click="submit"
                                            color="success">
                                            <v-icon>add</v-icon> Valider
                                        </v-btn> 
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-flex>
                        </v-layout>
                    </v-card-actions>
            </v-form>
        </div>
    </div>
</template>

<script>
    import categoriesMethods from './../../services/categories.js'
    import languagesMethods from './../../services/languages.js'

    export default {
        props: ['idSelected'],
        data () {
            return {
                categories: [],
                categoriesNames: [],
                languages: [],
                valid: true,
                namesInitial: [],
                names: [],
                nameRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length <= 50) || "Trop long !"
                ],
                iconsPrefix: [
                    { text: 'Material', code: '' },
                    { text: 'Font Awesome', code: 'fa-' },
                    // { text: 'Material Design', code: 'mdi-' },
                ],
                selectedPrefix: "",
                icon: '',
                iconTotal: '',
                iconRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length <= 40) || "Trop long !"
                ],
                colors: [
                    { text: 'Rouge', code: '#B71C1C' },
                    { text: 'Orange sombre', code: '#F4511E' },
                    { text: 'Orange', code: '#FFA726' },
                    { text: 'Jaune', code: '#FFC400' },
                    { text: 'Cyan', code: '#006064' },
                    { text: 'Bleu', code: '#01579B' },
                    { text: 'Bleu clair', code: '#1E88E5' },
                    { text: 'Violet', code: '#4A148C' },
                    { text: 'Bordeaux', code: '#880E4F' },
                    { text: 'Rose', code: '#F50057' },
                    { text: 'Vert sombre', code: '#1B5E20' },
                    { text: 'Vert', code: '#388E3C' },
                    { text: 'Vert clair', code: '#4CAF50' },
                ],
                selectedColor: "",
            }
        },
        watch: {
            idSelected(val, oldVal){
                console.log("id changed in category THIS IS NOT SUPPOSED TO HAPPEN.");console.log("Previous value : "+val+" New value : "+oldVal);
            },
            namesInitial(val, oldVal){
                this.editMode();
            },
            selectedColor(val, oldVal){
                document.getElementById('coloredDiv').style.backgroundColor = val;
            },
        },
        methods: {
            editMode(){
                if (this.idSelected != null) {
                    //set name(s) :
                        for (let i = 0; i < this.categoriesNames.length; i++) {
                            if (this.idSelected == this.categoriesNames[i]["fk_category_id"]) {
                                for (let y = 0; y < this.languages.length; y++) {
                                    if (this.categoriesNames[i]["fk_language_code"] == this.languages[y]["code"]) {
                                        this.names[y] = this.categoriesNames[i]["text"]
                                    }
                                }
                            }
                        }
                    var icon;
                    //search for color & icon & set color :
                        for (let x = 0; x < this.categories.length; x++) {
                            if (this.idSelected == this.categories[x]["id"]) {
                                this.selectedColor = this.categories[x]["color"];
                                icon = this.categories[x]["icon"];
                            }
                        }

                    //set icon
                    var prefix = icon.substring(0,3);
                    if (prefix == "fa-" || prefix == "mdi-") {
                        this.selectedPrefix = prefix;
                        this.icon = icon.substring(3);
                        
                        
                    }else{
                        this.icon = icon;
                    }
                }
                else{
                    this.selectedPrefix = "";
                    this.icon = "";
                    this.selectedColor = "";
                }
            },
            submit () {
                if (this.$refs.form.validate()) {
                    // Native form submission is not yet supported
                    // axios.post('/api/contactform', {
                    //     name: this.name,
                    //     icon: this.icon,
                    //     color: this.color
                    // })
                }
            },
            //API CALLS
                methodsApiCalls() {
                    this.categories = categoriesMethods.readCategories();
                    this.categoriesNames = categoriesMethods.readCategoriesNames();
                    this.languages = languagesMethods.readLanguages();

                    //setting initial empty names
                    window.axios.get('/api/languages').then(({ data }) => {
                        data.forEach(language => {
                            this.names.push("");
                            this.namesInitial.push("");
                        });
                    });
                },
        },
        created() {
            this.methodsApiCalls();
        }
    }
</script>

<style scoped>
    #coloredDiv{
        width: 50%;
        height: 20px;
        border-radius: 5px;
    }
</style>