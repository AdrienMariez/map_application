<template>
    <div>
        <div>
        <!-- BTN Reinit -->
            <div>
                <v-btn
                    @click="pageReinit"
                    color="lime lighten-3">
                    <v-icon>warning</v-icon> RESET
                </v-btn>
            </div>
        <!-- help -->
            <v-flex xs12>
                <v-btn
                    class="mt-5"
                    color="info"
                    @click="help = !help">
                    <v-icon>help</v-icon>
                    Aide
                </v-btn>
                <div
                    v-if="help"
                    class="elevation-5 my-3 mx-3 py-3 px-3">
                    <ul>
                        <li>Le bouton
                            <v-btn
                                color="lime lighten-3">
                                <v-icon>warning</v-icon> RESET
                            </v-btn>
                            permet:
                            <ul>
                                <li>
                                    En mode Création de reinitialiser (supprimer) toutes les informations entrées.
                                </li>
                                <li>
                                    En mode Edition de réinstaurer toutes les données telles qu'elles ont été sauvegardées la dernière fois. (les modifications seront supprimées !)
                                </li>
                            </ul>
                        </li>
                        <li>Les boutons <v-icon color="info">help</v-icon> indiquent que cliquer sur l'icône permet d'afficher une aide.
                        </li>
                        <li>Les boutons <v-icon color="purple lighten-1">help</v-icon>indiquent que passer sa souris sur l'icône permet d'afficher une aide.
                        </li>
                    </ul>
                </div>
            </v-flex>
        <!-- form -->
            <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                            <!-- Parent selection -->
                                <v-flex xs12 class="my-5">
                                    <div class="headline">Catégorie parent *: </div>
                                    <v-icon color="info"
                                    @click="helpParent = !helpParent">
                                    help
                                </v-icon>
                                <div
                                    v-if="helpParent"
                                    class="elevation-5 my-3 mx-3 py-3 px-3">
                                    <ul>
                                        <li>Sélectionner dans la liste le groupement qui contiendra cet élément.</li>
                                        <li>La couleur de l'icône parent déterminera la couleur de l'élément en cours de création/modification ainsi que ses points associés.</li>
                                    </ul>
                                </div>
                                    <v-select
                                        item-text="text"
                                        item-value="id"
                                        :items="categoryList"
                                        v-model="selectedCategory"
                                        solo
                                        required
                                    ></v-select>
                                    <div id="coloredDiv" class="py-3 px-3"></div>
                                    <div class="validationFailure">
                                        <v-icon v-if="categoryValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{categoryValidationFailure}}
                                    </div>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <v-divider></v-divider>
                                </v-flex>
                            <!-- Translations -->
                                <v-flex xs12 class="my-5">
                                    <div class="headline">Traductions *: </div>
                                    <v-icon
                                        color="info"
                                        @click="helpTranslations = !helpTranslations">
                                        help
                                    </v-icon>
                                    <div
                                        v-if="helpTranslations"
                                        class="elevation-5 my-3 mx-3 py-3 px-3">
                                        <div>Toutes les traductions de l'élément qui seront visibles dans la liste.</div>
                                    </div>
                                    <div class="subheading mb-3">Nom de la réference dans chaque langue *: </div>
                                    <div
                                        v-for="(language,i) in languages"
                                        :key="i">
                                        <div>
                                            {{language.name}}
                                        </div>
                                        <v-text-field
                                            v-model=names[i]
                                            :rules="nameRules"
                                            value= names[i]
                                            required
                                            solo
                                            :counter="50"
                                            class="mb-2"
                                        ></v-text-field>
                                    </div>
                                    <div class="validationFailure">
                                        <v-icon v-if="nameValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{nameValidationFailure}}
                                    </div>
                                </v-flex>
                            <!-- Icon selection/icon test -->
                                <v-flex xs12 class="my-5">
                                    <div class="headline">Icône *: </div>
                                    <v-icon
                                        color="info"
                                        @click="helpIcon = !helpIcon">
                                        help
                                    </v-icon>
                                    <div
                                        v-if="helpIcon"
                                        class="elevation-5 my-3 mx-3 py-3 px-3">
                                        <div>Choisir une librairie puis l'icône en elle-même pour l'élément de la liste de la page publique.</div>
                                        <div>L'icône sera aussi utilisée pour les points contenus dans cet élément.</div>
                                    </div>
                                <!-- Select library -->
                                    <div>Choix de la bibliothèque * : </div>
                                    <v-btn
                                        v-for="(prefix,i) in iconsPrefix"
                                        :key="i"
                                        :disabled="selectedPrefix == prefix.code"
                                        color="success"
                                        @click="setPrefix(prefix.code)">
                                        {{prefix.text}}
                                    </v-btn>
                                    <!-- OBSOLETE old select -->
                                            <!-- <v-select
                                                label="Sélectionner une bibliothèque"
                                                item-text="text"
                                                item-value="code"
                                                :items="iconsPrefix"
                                                v-model="selectedPrefix"
                                                solo
                                                required
                                                class="mt-2"
                                            ></v-select> -->
                                <!-- Hints how to use -->
                                    <div class="mb-4">
                                        <div
                                            v-if="selectedPrefix === 'fa-'">
                                            <v-tooltip right>
                                                <a
                                                    slot="activator"
                                                    id="linkDiv"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    href="https://fontawesome.com/icons?from=io">
                                                    Bibliothèque Font Awesome
                                                </a>
                                                <span>Ouverture dans un nouvel onglet</span>
                                            </v-tooltip>
                                            <v-tooltip right>
                                                <v-icon
                                                    color="purple lighten-1"
                                                    class="iconTooltip"
                                                    slot="activator">
                                                    help
                                                </v-icon>
                                                <ul>
                                                    <li>Ouvrir le lien.</li>
                                                    <li>Cliquer une fois sur le texte sous l'icône choisie,  copiez le.</li>
                                                    <li>Placer le texte ainsi sélectionné dans la zone "icône" ci-dessous.</li>
                                                </ul>
                                            </v-tooltip>
                                        </div>
                                        <div
                                            v-if="selectedPrefix === 'mdi-'">
                                            <v-tooltip right>
                                                <a
                                                    slot="activator"
                                                    id="linkDiv" target="_blank" rel="noopener noreferrer"
                                                    href="https://materialdesignicons.com/">
                                                    Bibliothèque Material Design
                                                </a>
                                                <span>Ouverture dans un nouvel onglet</span>
                                            </v-tooltip>
                                            <v-tooltip right>
                                                <v-icon
                                                    color="purple lighten-1"
                                                    class="iconTooltip"
                                                    slot="activator">
                                                    help
                                                </v-icon>
                                                <ul>
                                                    <li>Ouvrir le lien.</li>
                                                    <li>Cliquer sur l'icône choise.</li>
                                                    <li>Copier le titre de la fenêtre qui s'affiche.</li>
                                                </ul>
                                            </v-tooltip>
                                        </div>
                                    </div>
                                <!-- Text input choose icon -->
                                    <div>Choix de l'icône * : </div>
                                    <v-text-field
                                        class="mt-2 mb-4"
                                        v-model="icon"
                                        :rules="iconRules"
                                        hint="Icône utilisée par la reférence"
                                        required
                                        :counter="40"
                                    ></v-text-field>
                                <!-- Preview icon -->
                                    <div>Aperçu de {{selectedPrefix}}{{icon}} :
                                        <v-icon
                                            v-bind:style="{ color: selectedColor }"
                                            x-large>
                                            {{selectedPrefix}}{{icon}}
                                        </v-icon>
                                        <div v-if="icon.length > 0">Attention ! Pas plus d'une icône ne doit s'afficher ici !</div>
                                    </div>
                                    <div class="validationFailure">
                                        <v-icon v-if="iconValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{iconValidationFailure}}
                                    </div>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-layout align-center column justify-center>
                            <v-flex>
                                <v-btn
                                    v-if="!valid"
                                    :disabled="!valid"
                                    color="grey lighten-1">
                                    <v-icon>add</v-icon> Valider
                                </v-btn>
                                <v-btn
                                    v-if="valid"
                                    :disabled="!valid"
                                    @click="submit"
                                    large
                                    color="success">
                                    <v-icon>add</v-icon> Valider
                                </v-btn>
                            </v-flex>
                            <v-flex>
                                <div class="validationFailure mt-3">
                                    {{validationFailure}}
                                </div>
                            </v-flex>
                        </v-layout>
                    </v-card-actions>
            </v-form>
        </div>
        <!-- loading... -->
            <v-snackbar
                v-model="snackbarLoading"
                bottom
                right
                multi-line
                :timeout=0>
                Envoi en cours...
                <v-icon large>fas fa-circle-notch fa-spin</v-icon>
            </v-snackbar>
        <!-- snackbar info -->
            <v-snackbar
                v-model="snackbar"
                bottom
                right
                multi-line
                :timeout=6000
                >
                {{ snackText }}
                <v-btn
                    color="yellow lighten-1"
                    flat
                    @click="snackbar = false"
                >
                    Close
                </v-btn>
            </v-snackbar>
    </div>
</template>

<script>
    import referencesMethods from './../../services/references.js'
    import categoriesMethods from './../../services/categories.js'
    import languagesMethods from './../../services/languages.js'

    export default {
        props: ['idSelected', 'page','categories','categoriesNames','references','referenceNames'],
        data () {
            return {
                mute: false,
                loading: true,

                help: false,
                helpParent: false,
                helpTranslations: false,
                helpIcon: false,

                // references: [],
                // referenceNames: [],
                // categories: [],
                // categoriesNames: [],
                languages: [],

                valid: false,
                validationFailure: "",
                nameValidationFailure: "",
                iconValidationFailure: "",
                categoryValidationFailure: "",

                namesInitial: [],
                fk_cat: null,
                categoryList: [],
                selectedCategory: null,
                selectedColor: "",
                fk_id: [],
                names: [],
                codes:  [],
                nameRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length <= 50) || "Trop long !"
                ],
                
                iconsPrefix: [
                    { text: 'Font Awesome', code: 'fa-' },
                    { text: 'Material Design', code: 'mdi-' },
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

                snackbarLoading: false,
                snackText: "",
                snackbar: false,

                reference: {
                    id: null,
                    fk_category_id: null,
                    icon: '',
                    weight: null,
                },
            }
        },
        watch: {
            loading(val, oldVal) {
                if (val === false) {
                    // console.log("loading finished !");
                    this.pageInit();
                }
            },
            idSelected(val, oldVal){
                console.log("id changed in reference THIS IS NOT SUPPOSED TO HAPPEN.");console.log("Previous value : "+val+" New value : "+oldVal);
            },
            namesInitial(val, oldVal){
                // this.pageInit();
            },
            names(){
                this.validation();
            },
            icon(val, oldVal) {
                this.icon = val.toLowerCase();
                this.validation();
            },
            selectedCategory(val, oldVal){
                this.setIconColor(val);
                this.validation();
            },  
            valid(val, oldVal){
                //front validation
                this.validation();
            },
        },
        methods: {
            pageInit(){
                console.log("");
                
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
                console.log("");
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
                    if (prefix == "fa-") {
                        this.selectedPrefix = prefix;
                        this.icon = icon.substring(3);
                    }
                    else if(prefix == "mdi") {
                        this.selectedPrefix = "mdi-";
                        this.icon = icon.substring(4);
                    }
                    else{
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

            pageReinit(){
                console.log("");
                this.loading = true;
                this.methodsApiCalls();
                this.names = [];
                this.selectedCategory = null;
                this.selectedPrefix = "";
                this.icon = "";
                this.pageInit()
            },

            setPrefix(code) {
                this.selectedPrefix = code;
            },
            
            validation() {
                //front validation
                var valid = true;
                var validationFailure = "Impossible de créer la référence pour les raisons suivantes :  ";
                var nameValidationFailure = "";
                var iconValidationFailure = "";
                var categoryValidationFailure = "";

                // Name
                    var missingName = false;
                    var errorName = false;
                    for (let name = 0; name < this.names.length; name++) {
                        if (this.names[name].length == 0) {
                            missingName = true
                        }
                        if (this.names[name].length > 50) {
                            errorName = true
                        }
                    }
                    if (missingName === true) {
                        valid = false;
                        validationFailure += " Au moins l'un des noms de la référence est manquant.";
                        nameValidationFailure += "Au moins l'un des noms de la référence est manquant.";
                    }
                    if (errorName === true) {
                        valid = false;
                        validationFailure += " Au moins l'un des noms de la référence est invalide.";
                        nameValidationFailure += "Au moins l'un des noms de la référence est invalide.";
                    }
                // END Name
                // Icon
                    var missingIcon = false;
                    var errorIcon = false;
                    if (this.icon.length == 0) {
                        valid = false;
                        validationFailure += " Aucune icône sélectionnée.";
                        iconValidationFailure += "Aucune icône sélectionnée.";
                    }
                    if (this.icon.length > 40) {
                        valid = false;
                        validationFailure += " Le nom de l'icône est trop long.";
                        iconValidationFailure += "Le nom de l'icône est trop long.";
                    }
                // END Icon
                // Category
                    if (this.selectedCategory === null) {
                        valid = false;
                        validationFailure += " Aucune catégorie parent sélectionnée.";
                        categoryValidationFailure = "Aucune catégorie parent sélectionnée.";
                    }
                // END Category

                if (valid == true) {
                    this.valid = true;
                    this.validationFailure = "";
                }
                else{
                    this.valid = false;
                    this.validationFailure = validationFailure;
                }

                this.nameValidationFailure = nameValidationFailure;
                this.iconValidationFailure = iconValidationFailure;
                this.categoryValidationFailure = categoryValidationFailure;
            },

            submit () {
                if (this.$refs.form.validate()) {

                    this.snackbarLoading = true;

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
                //We use all the references to determine the weight so that if a reference is moved from one category from another, their weight will still be unique.
                for (let i = 0; i < this.references.length; i++) {
                    if (this.references[i]["weight"] >= weight) {
                        weight = this.references[i]["weight"] + 1;
                    }
                }
                this.reference.fk_category_id = fk_category_id;
                this.reference.icon = icon;
                this.reference.weight = weight;
                var newReference = this.reference;

                console.log("");

                // Cannot place this elsewhere or the promise does not work
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

                console.log("");

                referencesMethods.editReference(id, newReference);
                
                this.$emit('pageToShow', "", null);
                
            },
            createReferenceNames(id, names){
                for (let i = 0; i < names.length; i++) {
                    var newReferenceName = {
                        "fk_reference_id": id,
                        "fk_language_code": this.languages[i]["code"],
                        "text": names[i]
                    };

                    console.log("");

                    // referencesMethods.createReferenceName(newReferenceName);
                    axios.post('/api/referencesnames', newReferenceName)
                        .then(
                        response =>
                            Promise.all([
                            response,
                            console.log("")
                            ,
                            this.success(response, "Création effectuée !"),
                            ])   
                        )
                        .catch(function (error) {
                            console.log(error.response.data);
                                        
                            // alert("Un problème est survenu lors de la création. Error located in EditReference.vue !");

                            this.failed(error, "Erreur lors de la création de la référence !");
                        });
                }
                this.$emit('pageToShow', "", null);
            },
            updateReferenceNames(id, fk_reference_id, codes, names){
                for (let i = 0; i < names.length; i++) {
                    var newReferenceName = {
                        "fk_reference_id": fk_reference_id,
                        "fk_language_code": codes[i],
                        "text": names[i]
                    };

                    console.log("");

                    // referencesMethods.editReferenceName(id[i],newReferenceName);

                    axios.patch('/api/referencesnames/' + id[i], newReferenceName)
                        .then(
                            response =>
                                Promise.all([
                                response,
                                console.log("")
                                ,
                                this.success(response, "Mise à jour effectuée !"),
                                ])   
                            )
                        .catch(function (error) {
                            console.log(error.response.data);
                                        
                            // alert("Un problème est survenu lors de la mise à jour. Error located in EditReference.vue !");

                            this.failed(error, "Erreur lors de la mise à jour de la référence !");
                        });
                }
                this.$emit('pageToShow', "", null);
            },

            success(response, msg) {
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = msg;
            },
            failed(error) {
                console.log(error);
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = msg;
            },

            //API CALLS
                methodsApiCalls() {

                    // this.references = referencesMethods.readReferences();
                    // this.referenceNames = referencesMethods.readReferenceNames();
                    // this.categories = categoriesMethods.readCategories();
                    // this.categoriesNames = categoriesMethods.readCategoriesNamesFrOnly();
                    this.languages = languagesMethods.readLanguages();

                    //setting initial empty names
                    window.axios.get('/api/languages').then(({ data }) => {
                        data.forEach(language => {
                            this.names.push("");
                            this.namesInitial.push("");
                        });
                        this.loading = false;
                    });

                    // function resolveAfter2Seconds() {
                    //     return new Promise(resolve => {
                    //         setTimeout(() => {
                    //         resolve('resolved');
                    //         }, 2000);
                    //     });
                    // }

                    // async function asyncCall() {
                        // console.log('calling');
                        // var result = await resolveAfter2Seconds();
                        // console.log(result);
                        // expected output: 'resolved'
                    // }

                    // asyncCall();

                    return new Promise(resolve => {
                        setTimeout(() => {
                            resolve('resolved');
                        }, 2000);
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