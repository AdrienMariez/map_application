<template>
    <div>
        <div>
            <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 class="my-5">
                                    <div>Nom de la catégorie dans chaque langue *: </div>
                                    <v-text-field
                                        v-for="(language,i) in languages"
                                        :key="i"
                                        v-model=names[i]
                                        :rules="nameRules"
                                        :label= language.name
                                        value= names[i]
                                        required
                                        :counter="50"
                                        class="mb-2"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <div>Icone utilisée : </div>
                                    <!-- select library -->
                                    <v-select
                                        label="origine de l'icone :"
                                        item-text="text"
                                        item-value="code"
                                        :items="iconsPrefix"
                                        v-model="selectedPrefix"
                                        required
                                        class="mb-2"
                                    ></v-select>
                                    <!-- hints how to use -->
                                    <div>
                                        <div
                                            v-if="selectedPrefix === ''">
                                            <div>
                                                <a
                                                    id="linkDiv" target="_blank" rel="noopener noreferrer"
                                                    href="https://material.io/tools/icons/?style=baseline">
                                                    Bibliothèque Material
                                                </a>
                                                (nouvel onglet)
                                            </div>
                                            <v-tooltip
                                                top>
                                                <v-icon slot="activator">help</v-icon>
                                                <div>
                                                    <div>Ouvrir le lien.</div>
                                                    <div>Cliquer sur l'icône choise.</div>
                                                    <div>Cliquer sur Selected Icon en bas à gauche de l'écran.</div> 
                                                    <div>Copier le lien à côté de l'icône en haut.</div>
                                                    <div>Placer le texte ainsi sélectionné dans la zone "icône" ci-dessous.</div>
                                                </div>
                                            </v-tooltip>
                                        </div>
                                        <div
                                            v-if="selectedPrefix === 'fa-'">
                                            <div>
                                                <a
                                                    id="linkDiv" target="_blank" rel="noopener noreferrer"
                                                    href="https://fontawesome.com/icons?from=io">
                                                    Bibliothèque Font Awesome
                                                </a>
                                                (nouvel onglet)
                                            </div>
                                            <v-tooltip
                                                top>
                                                <v-icon slot="activator">help</v-icon>
                                                <div>
                                                    <div>Ouvrir le lien.</div>
                                                    <div>Cliquer une fois sur le texte sous l'icône choisie,  copiez le.</div>
                                                    <div>Placer le texte ainsi sélectionné dans la zone "icône" ci-dessous.</div>
                                                </div>
                                            </v-tooltip>
                                        </div>
                                        <div
                                            v-if="selectedPrefix === 'mdi-'">
                                            <div>
                                                <a
                                                    id="linkDiv" target="_blank" rel="noopener noreferrer"
                                                    href="https://materialdesignicons.com/">
                                                    Bibliothèque Material Design
                                                </a>
                                                (nouvel onglet)
                                            </div>
                                            <v-tooltip
                                                top>
                                                <v-icon slot="activator">help</v-icon>
                                                <div>
                                                    <div>Ouvrir le lien.</div>
                                                    <div>Cliquer sur l'icône choise.</div>
                                                    <div>Copier le titre de la fenêtre qui s'affiche.</div>
                                                </div>
                                            </v-tooltip>
                                        </div>
                                    </div>
                                    <!-- text input choose icon -->
                                    <v-text-field
                                        v-model="icon"
                                        :rules="iconRules"
                                        label="icône *"
                                        hint="icône utilisée par la catégorie"
                                        required
                                        :counter="40"
                                    ></v-text-field>
                                    <!-- autocomplete -->
                                    <!-- <v-autocomplete
                                        v-model="icon"
                                        hint="Selectionner l'icône"
                                        :items="iconList"
                                        persistent-hint
                                    >
                                    </v-autocomplete> -->
                                    <!-- END autocomplete -->
                                    <!-- preview icon -->
                                    <div>Aperçu de {{selectedPrefix}}{{icon}} :
                                        <v-icon
                                            v-bind:style="{ color: selectedColor }"
                                            x-large>
                                            {{selectedPrefix}}{{icon}}
                                        </v-icon>
                                        <div v-if="icon.length > 0">Attention ! Pas plus d'une icône ne doit s'afficher ici !</div>
                                    </div>
                                </v-flex>
                                <v-divider></v-divider>
                                <v-flex xs12 class="my-5">
                                    <div>Couleur de l'icone de la catégorie *: </div>
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
                mute: false,
                loading: true,
                categories: [],
                categoriesNames: [],

                languages: [],
                codes:  [],

                valid: false,
                namesInitial: [],
                fk_id: [],

                names: [],
                nameRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length <= 50) || "Trop long !"
                ],

                iconsPrefix: [
                    { text: 'Material', code: '' },
                    { text: 'Font Awesome', code: 'fa-' },
                    { text: 'Material Design', code: 'mdi-' },
                ],
                //used in autocomplete
                // iconList: [
                //     'A', 'B', 'C', 'D',
                //     'E', 'F', 'G', 'H',
                //     'I', 'J', 'K',
                //     'L', 'M', 'N', 'O'
                // ],
                selectedPrefix: "",

                icon: '',
                iconTotal: '',
                iconRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length <= 40) || "Trop long !"
                    //  1.027538            1.360224
                    //  44.392567           44.590387
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

                category: {
                    id: null,
                    icon: '',
                    color: '',
                    weight: null,
                },
            }
        },
        watch: {
            idSelected(val, oldVal){
                console.log("id changed in category THIS IS NOT SUPPOSED TO HAPPEN.");console.log("Previous value : "+val+" New value : "+oldVal);
            },
            namesInitial(val, oldVal){
                this.editMode();
            },
            icon(val, oldVal) {
                this.icon = val.toLowerCase();
            },
            selectedColor(val, oldVal){
                document.getElementById('coloredDiv').style.backgroundColor = val;
            },  
            valid(val, oldVal){
                for (let i = 0; i < this.names.length; i++) {
                    if (this.names[i].length == 0 || this.names[i].length > 50) {
                        this.valid = false;
                    }
                }
                if (this.icon.length == 0 || this.icon.length > 40) {
                    this.valid = false;
                }
                if (this.selectedColor.length == 0) {
                    this.valid = false;
                }
                // console.log("names "+this.names);
                // console.log("icon "+this.icon);
                // console.log("selectedColor "+this.selectedColor);
                // console.log("valid "+this.valid);
            },
        },
        methods: {
            editMode(){
                if (this.idSelected != null) {
                    //set name(s) :
                        for (let i = 0; i < this.categoriesNames.length; i++) {
                            if (this.idSelected == this.categoriesNames[i]["fk_category_id"]) {
                                for (let y = 0; y < this.languages.length; y++) {
                                    if (this.categoriesNames[i]["fk_language_code"] ==          this.languages[y]["code"]) {
                                        this.fk_id[y] = this.categoriesNames[i]["id"];

                                        this.names[y] = this.categoriesNames[i]["text"];

                                        this.codes[y] = this.categoriesNames[i]["fk_language_code"];
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
                    this.valid = false;
                }
            },
            submit () {
                if (this.$refs.form.validate()) {
                    // console.log("names "+this.names);
                    // console.log("icon "+this.iconTotal);
                    // console.log("selectedColor "+this.selectedColor);
                    var icon = this.selectedPrefix +""+ this.icon;

                    if(this.idSelected === null){
                        this.createCategory(icon, this.selectedColor);
                    }
                    else{
                        this.updateCategory(this.idSelected, icon, this.selectedColor);
                        this.updateCategoryNames(this.fk_id, this.idSelected,this.codes, this.names);
                    }
                    // Native form submission is not yet supported
                    // axios.post('/api/category', {
                    //     name: this.name,
                    //     icon: this.icon,
                    //     color: this.color
                    // })
                }
            },
            createCategory(icon, color) {
                var weight = 0;
                for (let i = 0; i < this.categories.length; i++) {
                    if (this.categories[i]["weight"] >= weight) {
                        weight = this.categories[i]["weight"] + 1;
                    }
                }
                this.category.icon = icon;
                this.category.color = color;
                this.category.weight = weight;
                var newCategory = this.category;

                axios.post('/api/categories', newCategory)
                    .then(
                    resp =>
                        Promise.all([
                        resp,
                        this.createCategoryNames(resp.data.id, this.names),
                        ])   
                    )
                    .then(function (resp) {
                    })
                    .catch(function (error) {
                        console.log(error.response.data);
                        
                        alert("Un problème est survenu lors de la création. Error located in EditCategory.vue !");
                    });
            },
            updateCategory(id, icon, color) {
                var weight = 0;
                for (let i = 0; i < this.categories.length; i++) {
                    if (this.categories[i]["id"] == this.idSelected) {
                        weight = this.categories[i]["weight"];
                    }
                }
                //
                    // this.mute = true;
                    // window.axios.put(`/api/categories/${id}`, { icon }, { color }, { weight }).then(() => {
                    //     console.log("in axios ?");
                    //     this.categories.find(category => category.id === id).icon = icon;
                    //     this.mute = false;
                    // });
                //
                this.category.icon = icon;
                this.category.color = color;
                this.category.weight = weight;
                var newCategory = this.category;

                categoriesMethods.editCategory(id, newCategory);

                this.$emit('pageToShow', "", null);
                
            },
            createCategoryNames(id, names){
                
                for (let i = 0; i < names.length; i++) {
                    var newCategoryName = {
                        "fk_category_id": id,
                        "fk_language_code": this.languages[i]["code"],
                        "text": names[i]
                    };
                    
                    axios.post('/api/categoriesnames', newCategoryName)
                        .then(function (resp) {
                        })
                        .catch(function (error) {
                            console.log(error.response.data);
                            
                            alert("Un problème est survenu lors de la création. Error located in EditCategory.vue !");
                        });
                }

                this.$emit('pageToShow', "", null);
            },
            updateCategoryNames(id, fk_id, codes, names){
                for (let i = 0; i < names.length; i++) {
                    var newCategoryName = {
                        "fk_category_id": fk_id,
                        "fk_language_code": codes[i],
                        "text": names[i]
                    };

                    categoriesMethods.editCategoryName(id[i], newCategoryName);
                }
                this.$emit('pageToShow', "", null);
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
                        this.loading = false;
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