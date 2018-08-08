<template>
    <div>
        <div>
            <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 class="my-5">
                                    <div>Réference parent *: </div>
                                    <v-select
                                        item-text="text"
                                        item-value="id"
                                        :items="referenceList"
                                        v-model="selectedReference"
                                        required
                                    ></v-select>
                                    <div class="my-2" id="coloredDiv"></div>
                                    <div class="my-2">Aperçu de {{icon}} :
                                        <v-icon
                                            v-bind:style="{ color: selectedColor }"
                                            x-large>
                                            {{icon}}
                                        </v-icon>
                                    </div>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <div>Lien : </div>
                                    <v-text-field
                                        v-model=link
                                        value= link
                                        :counter="100"
                                        class="mb-2"
                                    ></v-text-field>
                                    <div v-if="link.length > 0">
                                        <a
                                            id="linkDiv" target="_blank" rel="noopener noreferrer"
                                            v-bind:href="link">
                                            test du lien
                                        </a>
                                        (nouvel onglet)
                                    </div>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <v-expansion-panel>
                                        <v-expansion-panel-content
                                            v-for="(language,i) in languages"
                                            :key="i">
                                            <div slot="header">{{language.name}}</div>
                                            <v-card>
                                                <div>Nom du point *: </div>
                                                <v-text-field
                                                    v-model=titles[i]
                                                    :rules="nameRules"
                                                    value= titles[i]
                                                    required
                                                    :counter="50"
                                                    class="mb-2"
                                                ></v-text-field>
                                                <div>Description du point *: </div>
                                                <v-text-field
                                                    v-model=desc[i]
                                                    :rules="nameRules"
                                                    value= desc[i]
                                                    :counter="50"
                                                    class="mb-2"
                                                ></v-text-field>
                                                <div v-if="link.length > 0">link alias du point *: </div>
                                                <v-text-field
                                                    v-if="link.length > 0"
                                                    v-model=linkAlias[i]
                                                    value= linkAlias[i]
                                                    :counter="50"
                                                    class="mb-2"
                                                ></v-text-field>
                                            </v-card>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <v-expansion-panel>
                                        <v-expansion-panel-content>
                                            <div slot="header">Banque d'images</div>
                                            <v-card>
                                                <v-layout align-center justify-space-around fill-height row wrap>
                                                    <v-flex
                                                        v-for="(img,i) in images"
                                                        :key="i"
                                                        class="imgContainer xs3 ma-3">
                                                        <img
                                                            xs3
                                                            color="transparent" :src="img.image_path"
                                                            @click="selectImage(img.id)">
                                                    </v-flex>
                                                </v-layout>
                                            </v-card>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-content>
                                            <div slot="header">Ajout d'un nouveau fichier</div>
                                            <div class="card card-default">
                                                <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input
                                                            type="file"
                                                            accept="image/*"
                                                            v-on:change="onImageChange"
                                                            class="form-control">
                                                    </div>
                                                    <div
                                                        class="col-md-3" v-if="imageUpload">
                                                        <img :src="imageUpload" class="img-responsive" height="70" width="90">
                                                    </div>
                                                    <div
                                                        class="col-md-3"
                                                        v-if="imageUpload">
                                                        <button class="btn btn-success btn-block" @click="uploadImage">Upload Image</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <div v-if="image.length !== 0" class="card card-default">
                                        <div class="card-header">Image utilisée :</div>
                                            <div class="card-body">
                                                <div class="row imgContainerPreview xs3 ma-3">
                                                    <img
                                                        xs3
                                                        v-bind:src="image"
                                                        alt="aperçu de l'image">
                                                </div>
                                            </div>
                                        </div>
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
    import ImageList from "./ImageList.vue";

    import imagesMethods from './../../services/images.js'
    import pointsMethods from './../../services/points.js'
    import referencesMethods from './../../services/references.js'
    import categoriesMethods from './../../services/categories.js'
    import languagesMethods from './../../services/languages.js'

    export default {
        props: ['idSelected', 'page'],
        data () {
            return {
                mute: false,
                loading: true,
                points: [],
                pointsContents: [],
                images: [],
                references: [],
                referenceNames: [],
                categories: [],
                categoriesNames: [],
                languages: [],
                valid: false,
                fk_cat: null,
                fk_ref: null,
                referenceList: [],
                selectedReference: null,
                selectedReferenceId: null,
                selectedColor: "",
                fk_id: [],
                titles: [],
                titlesInitial: [],
                desc: [],
                linkAlias: [],
                codes:  [],
                link: "",
                image: "",
                image_fk: "",
                imageInitial_fk : "",
                imageUpload: "",
                snackbarLoading: false,
                snackText: "",
                snackbar: false,
                nameRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length <= 50) || "Trop long !"
                ],
                icon: '',
                iconTotal: '',
                imageToUpload: {
                    id: null,
                    image_path: "",
                },
            }
        },
        watch: {
            idSelected(val, oldVal){
                console.log("id changed in reference THIS IS NOT SUPPOSED TO HAPPEN.");console.log("Previous value : "+val+" New value : "+oldVal);
            },
            titlesInitial(val, oldVal){
                this.pageInit();
            },
            selectedReference(val, oldVal){
                this.setIcon(val);
            },  
            valid(val, oldVal){
                //front validation
                for (let i = 0; i < this.titles.length; i++) {
                    if (this.titles[i].length == 0 || this.titles[i].length > 50) {
                        this.valid = false;
                    }
                }
                if (this.icon.length == 0 || this.icon.length > 40) {
                    this.valid = false;
                }
                if (this.selectedReference === null) {
                    this.valid = false;
                }
                // console.log("titles "+this.titles);
                // console.log("icon "+this.icon);
                // console.log("selectedColor "+this.selectedColor);
                // console.log("valid "+this.valid);
            },
        },
        methods: {
            pageInit(){
                //baking references list
                for (let a = 0; a < this.references.length; a++) {
                    for (let b = 0; b < this.referenceNames.length; b++) {
                        if (this.references[a]["id"] === this.referenceNames[b]["fk_reference_id"]) {
                            var refListObjet = {
                                "id": this.references[a]["id"],
                                "text": this.referenceNames[b]["text"]
                            };
                            this.referenceList.push(refListObjet);
                        }
                    }
                }
                //In edit mode
                if (this.page == "point") {
                    this.editMode();
                }
                //In create mode
                else if(this.page == "pointParent"){
                    this.createMode();
                }
                //in error mode, I suppose
                else{
                    console.log("error with the parameters of the page located in EditPoint.vue !");
                    alert("Un problème est survenu lors de l'affichage de la page, veuillez recharger.");
                }
            },
            editMode() {
                //set name(s) :
                        for (let i = 0; i < this.pointsContents.length; i++) {
                            if (this.idSelected == this.pointsContents[i]["fk_point_id"]) {
                                for (let y = 0; y < this.languages.length; y++) {
                                    if (this.pointsContents[i]["fk_language_code"] ==          this.languages[y]["code"]) {
                                        this.fk_id[y] = this.pointsContents[i]["id"];
                                        this.titles[y] = this.pointsContents[i]["title"];

                                        this.desc[y] = this.pointsContents[i]["description"];

                                        this.linkAlias[y] = this.pointsContents[i]["linkalias"];

                                        this.codes[y] = this.pointsContents[i]["fk_language_code"];
                                    }
                                }
                            }
                        }
                //search for fk_reference_id, fk_category_id & icon :
                        for (let x = 0; x < this.points.length; x++) {
                            if (this.idSelected == this.points[x]["id"]) {
                                this.link = this.points[x]["link"];
                                this.image_fk = this.points[x]["fk_image_id"];
                                this.imageInitial_fk = this.points[x]["fk_image_id"];
                                this.fk_ref = this.points[x]["fk_reference_id"];
                                for (let img = 0; img < this.images.length; img++) {
                                   if (this.images[img]["id"] == this.points[x]["fk_image_id"]) {
                                       this.image = this.images[img]["image_path"]
                                   }
                                }
                                for (let y = 0; y < this.references.length; y++) {
                                    if (this.references[y]["id"] == this.fk_ref) {
                                        this.fk_cat = this.references[y]["fk_category_id"];
                                        this.icon = this.references[y]["icon"];
                                    }
                                }
                            }
                        }

                //set object selectedReference
                    for (let y = 0; y < this.references.length; y++) {
                        if (this.fk_ref == this.references[y]["id"]) {
                           this.selectedReference = this.references[y]["id"];
                        }
                    }
            },
            createMode() {
                this.fk_ref = this.idSelected;
                //search for fk_category_id & icon :
                        for (let x = 0; x < this.references.length; x++) {
                            if (this.idSelected == this.references[x]["id"]) {
                                this.fk_cat = this.references[x]["fk_category_id"];
                                this.icon = this.references[x]["icon"];
                            }
                        }

                //set object selectedReference
                    for (let y = 0; y < this.references.length; y++) {
                        if (this.fk_ref == this.references[y]["id"]) {
                           this.selectedReference = this.references[y]["id"];
                        }
                    }
                this.valid = false;
            },
            setIcon(id) {
                for (let ref = 0; ref < this.references.length; ref++) {
                    if (this.references[ref]["id"] == id) {
                        this.icon = this.references[ref]["icon"];
                        for (let cat = 0; cat < this.categories.length; cat++) {
                            if (this.categories[cat]["id"] == this.references[ref]["fk_category_id"]) {
                                this.selectedColor = this.categories[cat]["color"];
                            }
                        }
                    }
                }
                // document.getElementById('coloredDiv').style.backgroundColor = this.selectedColor;
            },
            selectImage(img) {
                this.image_fk = img;
                var images = JSON.parse(JSON.stringify(this.images));
                for (let image = 0; image < images.length; image++) {
                    if (img === images[image]["id"]) {
                        this.image = images[image]["image_path"];
                    }
                }
            },

            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.imageUpload = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                this.snackbarLoading = true;
                axios.post('api/images/',{image: this.imageUpload})
                    .then(response => { 
                        this.successUpload(response);
                    })
                    .catch(error => {
                        this.failedUpload(error);
                    });
            },
            successUpload(response) {
                    this.snackbarLoading = false;
                    // console.log("success !");
                    // console.log(response);
                    this.snackbar = true;
                    this.snackText = "Upload effectué !"
                    this.images = imagesMethods.readImages();
                    this.imageUpload = "";
            },
            failedUpload(error) {
                    // console.log("error !");
                    // console.log(error.response.data);
                    this.snackbar = true;
                    this.snackText = "Erreur lors de l'upload du fichier ! Le format n'est pas reconnu."
                    this.snackbarLoading = false;
                    // if (error.response.data.message == "Image source not readable"){
                    //     this.snackText = "Le format du fichier n'est pas reconnu."
                    // }
                    // else{
                    //     this.snackText = "Erreur inconnue avec le fichier."
                    // }
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
                        this.updateReferenceNames(this.fk_id, this.idSelected, this.codes, this.titles);
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
                        this.createReferenceNames(resp.data.id, this.titles),
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
                    this.images = imagesMethods.readImages();
                    this.points = pointsMethods.readPoints();
                    this.pointsContents = pointsMethods.readPointsPopupContent();
                    this.references = referencesMethods.readReferences();
                    this.referenceNames = referencesMethods.readReferenceNamesFrOnly();
                    this.categories = categoriesMethods.readCategories();
                    this.categoriesNames = categoriesMethods.readCategoriesNamesFrOnly();
                    this.languages = languagesMethods.readLanguages();

                    //setting initial empty names
                    window.axios.get('/api/languages').then(({ data }) => {
                        data.forEach(language => {
                            this.titles.push("");
                            this.desc.push("");
                            this.linkAlias.push("");
                            this.titlesInitial.push("");
                        });
                        this.loading = false;
                    });
                },
        },
        created() {
            this.methodsApiCalls();
        },
        components: {
            ImageList
        }
    }
</script>

<style scoped>
    #coloredDiv{
        width: 50%;
        height: 20px;
        border-radius: 5px;
    }
    .imgContainer{
        /* width:150px !important; */
        width:100px !important;
        min-width:70px !important;
        /* max-height:200px !important; */
        /* background-color: red; */
        box-shadow: 0px 5px 10px 2px #afafaf;
    }
    .imgContainerPreview{
        width:250px !important;
        box-shadow: 0px 5px 10px 2px #afafaf;
    }
    .imgContainer > img, .imgContainerPreview > img{
        width:100% !important;
        height:100% !important;
    }
</style>