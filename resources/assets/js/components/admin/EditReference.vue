<template>
    <div>
        <div>
            <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 class="my-5">
                                    <div>Catégorie parent *: </div>
                                    <v-select
                                        item-text="text"
                                        item-value="id"
                                        :items="categoryList"
                                        v-model="selectedCategory"
                                        required
                                    ></v-select>
                                    <div id="coloredDiv"></div>
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
                                        label="icone *"
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
                                <v-flex xs12 class="my-5">
                                    <div>Nom de la réference dans chaque langue *: </div>
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
                                <v-divider></v-divider>
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
    import referencesMethods from './../../services/references.js'
    import categoriesMethods from './../../services/categories.js'
    import languagesMethods from './../../services/languages.js'

    export default {
        props: ['idSelected', 'page'],
        data () {
            return {
                mute: false,
                loading: true,
                references: [],
                referenceNames: [],
                categories: [],
                categoriesNames: [],
                languages: [],
                valid: false,
                namesInitial: [],
                fk_cat: null,
                categoryList: [],
                selectedCategory: null,
                selectedCategoryId: null,
                selectedColor: "",
                fk_id: [],
                names: [],
                codes:  [],
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
                reference: {
                    id: null,
                    fk_category_id: null,
                    icon: '',
                    weight: null,
                },
            }
        },
        watch: {
            idSelected(val, oldVal){
                console.log("id changed in reference THIS IS NOT SUPPOSED TO HAPPEN.");console.log("Previous value : "+val+" New value : "+oldVal);
            },
            namesInitial(val, oldVal){
                this.pageInit();
            },
            selectedCategory(val, oldVal){
                this.setIconColor(val);
            },  
            valid(val, oldVal){
                //front validation
                for (let i = 0; i < this.names.length; i++) {
                    if (this.names[i].length == 0 || this.names[i].length > 50) {
                        this.valid = false;
                    }
                }
                if (this.icon.length == 0 || this.icon.length > 40) {
                    this.valid = false;
                }
                if (this.selectedCategory === null) {
                    this.valid = false;
                }
                // console.log("names "+this.names);
                // console.log("icon "+this.icon);
                // console.log("selectedColor "+this.selectedColor);
                // console.log("valid "+this.valid);
            },
        },
        methods: {
            pageInit(){
                //baking category list
                for (let a = 0; a < this.categories.length; a++) {
                    for (let b = 0; b < this.categoriesNames.length; b++) {
                        if (this.categories[a]["id"] === this.categoriesNames[b]["fk_category_id"]) {
                            var catListObjet = {
                                "id": this.categories[a]["id"],
                                "text": this.categoriesNames[b]["text"]
                            };
                            this.categoryList.push(catListObjet);
                        }
                    }
                }
                //In edit mode
                if (this.page == "reference") {
                    this.editMode();
                }
                //In create mode
                else if(this.page == "referenceParent"){
                    this.createMode();
                }
                //in error mode, I suppose
                else{
                    console.log("error with the parameters of the page located in EditReference.vue !");
                    alert("Un problème est survenu lors de l'affichage de la page, veuillez recharger.");
                }
            },
            editMode() {
                //set name(s) :
                        for (let i = 0; i < this.referenceNames.length; i++) {
                            if (this.idSelected == this.referenceNames[i]["fk_reference_id"]) {
                                for (let y = 0; y < this.languages.length; y++) {
                                    if (this.referenceNames[i]["fk_language_code"] ==          this.languages[y]["code"]) {
                                        this.fk_id[y] = this.referenceNames[i]["id"];

                                        this.names[y] = this.referenceNames[i]["text"];

                                        this.codes[y] = this.referenceNames[i]["fk_language_code"];
                                    }
                                }
                            }
                        }
                    var icon;
                //search for fk_category_id & icon :
                        for (let x = 0; x < this.references.length; x++) {
                            if (this.idSelected == this.references[x]["id"]) {
                                this.fk_cat = this.references[x]["fk_category_id"];
                                icon = this.references[x]["icon"];
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
                //set object selectedCategory
                    for (let y = 0; y < this.categories.length; y++) {
                        if (this.fk_cat == this.categories[y]["id"]) {
                           this.selectedCategory = this.categories[y]["id"];
                        }
                    }
            },
            createMode() {
                this.fk_cat = this.idSelected;
                this.selectedPrefix = "";
                this.icon = "";
                this.valid = false;
                //set object selectedCategory
                    for (let y = 0; y < this.categories.length; y++) {
                        if (this.fk_cat == this.categories[y]["id"]) {
                           this.selectedCategory = this.categories[y]["id"];
                        }
                    }
            },
            setIconColor(id) {
                for (let i = 0; i < this.categories.length; i++) {
                    if (this.categories[i]["id"] == id) {
                        
                        this.selectedColor = this.categories[i]["color"];
                        
                    }
                }
                document.getElementById('coloredDiv').style.backgroundColor = this.selectedColor;
            },
            submit () {
                if (this.$refs.form.validate()) {
                    var icon = this.selectedPrefix +""+ this.icon;
                    //In create mode
                    if(this.page == "referenceParent"){
                        this.createReference(this.selectedCategory, icon);
                    }
                    //In edit mode
                    else if(this.page == "reference"){
                        this.updateReference(this.idSelected, this.selectedCategory, icon);
                        this.updateReferenceNames(this.fk_id, this.idSelected, this.codes, this.names);
                    }else{
                        alert("Un problème est survenu lors de l'execution. Error located in EditReference.vue !");
                    };
                }
            },
            createReference(fk_category_id, icon) {

                var weight = 0;
                for (let i = 0; i < this.references.length; i++) {
                    if (this.references[i]["weight"] >= weight) {
                        weight = this.references[i]["weight"] + 1;
                    }
                }
                this.reference.fk_category_id = fk_category_id;
                this.reference.icon = icon;
                this.reference.weight = weight;
                var newReference = this.reference;

                axios.post('/api/references', newReference)
                    .then(
                    resp =>
                        Promise.all([
                        resp,
                        this.createReferenceNames(resp.data.id, this.names),
                        ])   
                    )
                    .catch(function (error) {
                        console.log(error.response.data);
                        
                        alert("Un problème est survenu lors de la création. Error located in EditReference.vue !");
                    });
            },
            updateReference(id, fk_category_id, icon) {
                var weight = 0;
                for (let i = 0; i < this.references.length; i++) {
                    if (this.references[i]["id"] == this.idSelected) {
                        weight = this.references[i]["weight"];
                    }
                }

                this.reference.fk_category_id = fk_category_id;
                this.reference.icon = icon;
                this.reference.weight = weight;
                var newReference = this.reference;

                axios.patch('/api/references/' + id, newReference)
                    .then(function (resp) {
                    })
                    .catch(function (error) {
                        console.log(error.response.data);
                        
                        alert("Un problème est survenu lors de la mise à jour. Error located in EditReference.vue !");
                    });
                this.$emit('pageToShow', "", null);
                
            },
            createReferenceNames(id, names){
                
                for (let i = 0; i < names.length; i++) {
                    var newReferenceName = {
                        "fk_reference_id": id,
                        "fk_language_code": this.languages[i]["code"],
                        "text": names[i]
                    };

                    axios.post('/api/referencesnames', newReferenceName)
                        .then(function (resp) {

                        })
                        .catch(function (error) {
                            console.log(error.response.data);
                            
                            alert("Un problème est survenu lors de la création. Error located in EditReference.vue !");
                        });
                }
                this.$emit('pageToShow', "", null);
            },
            updateReferenceNames(id, fk_reference_id, codes, names){
                for (let i = 0; i < names.length; i++) {
                    //TO CHANGE
                    var newReferenceName = {
                        "fk_reference_id": fk_reference_id,
                        "fk_language_code": codes[i],
                        "text": names[i]
                    };
                    
                    axios.patch('/api/referencesnames/' + id[i], newReferenceName)
                        .then(function (resp) {
                            
                        })
                        .catch(function (error) {
                            console.log(error.response.data);
                            
                            alert("Un problème est survenu lors de la mise à jour.");
                        });
                }
                this.$emit('pageToShow', "", null);
            },
            //API CALLS
                methodsApiCalls() {
                    this.references = referencesMethods.readReferences();
                    this.referenceNames = referencesMethods.readReferenceNames();
                    this.categories = categoriesMethods.readCategories();
                    this.categoriesNames = categoriesMethods.readCategoriesNamesFrOnly();
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