<template>
    <div>
        <div>
            <div>
                <v-btn
                    @click="pageReinit"
                    color="lime lighten-3">
                    <v-icon>fas fa-circle-notch fa-spin</v-icon> Reinitialiser et mettre à jour
                </v-btn>
            </div>
            <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                            <!-- Select Parent / show icon -->
                                <v-flex xs12 class="my-5">
                                    <div>Réference parent *: </div>
                                    <v-select
                                        item-text="text"
                                        item-value="id"
                                        :items="referenceList"
                                        v-model="selectedReference"
                                        solo
                                        required
                                    ></v-select>
                                    <div class="my-2">Aperçu de l'icône de la référence sélectionnée :
                                        <v-icon
                                            v-bind:style="{ color: selectedColor }"
                                            x-large>
                                            {{icon}}
                                        </v-icon>
                                    </div>
                                    <div class="validationFailure">
                                        <v-icon v-if="fkrefValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{fkrefValidationFailure}}
                                    </div>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <v-divider></v-divider>
                                </v-flex>
                            <!-- Link /link test -->
                                <v-flex xs12 class="my-5">
                                    <div>Lien : </div>
                                    <v-text-field
                                        v-model=link
                                        value= link
                                        :counter="100"
                                        solo
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
                                    <v-divider></v-divider>
                                </v-flex>
                            <!-- Translations -->
                                <v-flex xs12 class="my-5">
                                    <v-expansion-panel class="elevation-10">
                                        <v-expansion-panel-content
                                            v-for="(language,i) in languages"
                                            :key="i"
                                            color="green lighten-3"
                                            class="green lighten-3 highlightHeader"
                                            :class="{ listColorAlt: i % 2 == 0 }">
                                            <div slot="header">
                                                <div></div>
                                                {{language.name}}
                                            </div>
                                            <v-card>
                                                <div>
                                                <!-- Title -->
                                                    <div class="my-4 mx-2 py-4 px-2">
                                                        <div>Nom du point *: </div>
                                                        <v-text-field
                                                            v-model=titles[i]
                                                            :rules="nameRules"
                                                            value= titles[i]
                                                            required
                                                            :counter="50">
                                                        </v-text-field>
                                                    </div>
                                                <!-- Description -->
                                                    <div class="my-4 mx-2 py-4 px-2">
                                                        <div>Description du point *: </div>
                                                        <v-text-field
                                                            v-model=desc[i]
                                                            :rules="nameRules"
                                                            value= desc[i]
                                                            :counter="50">
                                                        </v-text-field>
                                                    </div>
                                                <!-- Link alias -->
                                                    <div
                                                        v-if="link.length > 0"
                                                        class="my-4 mx-2 py-4 px-2">
                                                        <div>Texte du lien du point *: </div>
                                                        <v-text-field
                                                            v-model=linkAlias[i]
                                                            value= linkAlias[i]
                                                            :counter="50">
                                                        </v-text-field>
                                                    </div>
                                                </div>
                                            </v-card>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <div class="validationFailure">
                                        <v-icon v-if="titlesValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{titlesValidationFailure}}
                                    </div>
                                    <div class="validationFailure">
                                        <v-icon v-if="descValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{descValidationFailure}}
                                    </div>
                                    <div class="validationFailure">
                                        <v-icon v-if="linkAliasValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{linkAliasValidationFailure}}
                                    </div>
                                </v-flex>
                                <v-flex xs12 class="my-5">
                                    <v-divider></v-divider>
                                </v-flex>
                            <!-- Images -->
                                <image-point
                                    v-bind:image="image"
                                    @imageSelected="imageSelected"
                                    @clearImage="clearImage"
                                    @imageListReload="imageListReload">
                                </image-point>
                                <v-flex xs12 class="my-5">
                                    <v-divider></v-divider>
                                </v-flex>
                            <!-- Point positionning -->
                                <v-flex xs12 class="my-5">
                                    <location-map-admin
                                        v-bind:lattitude="lattitude"
                                        v-bind:longitude="longitude"
                                        v-bind:lattitudeUpdater="lattitudeUpdater"
                                        v-bind:longitudeUpdater="longitudeUpdater"
                                        v-bind:icon="icon"
                                        v-bind:markerColor="selectedColor"
                                        v-bind:pointPreview="pointPreview"
                                        v-bind:preview="preview"
                                        @pointLattitudeUpdate="pointLattitudeUpdate"
                                        @pointLongitudeUpdate="pointLongitudeUpdate">
                                    </location-map-admin>
                                    <div>
                                        Lattitude :
                                    </div>
                                    <v-text-field
                                        v-model="lattitudeUpdater"
                                        @change="pointLattitudeUpdate(lattitudeUpdater)"
                                        label="Lattitude"
                                        hint="Entre 44.590387  et 44.392567"
                                        single-line
                                        solo
                                    ></v-text-field>
                                    <div class="validationFailure">
                                        <v-icon v-if="lattitudeValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{lattitudeValidationFailure}}
                                    </div>
                                    <div>
                                        Longitude :
                                    </div>
                                    <v-text-field
                                        v-model="longitudeUpdater"
                                        @change="pointLongitudeUpdate(longitudeUpdater)"
                                        label="Longitude"
                                        hint="Entre 1.360224 et 1.027538"
                                        single-line
                                        solo
                                    ></v-text-field>
                                    <div class="validationFailure">
                                        <v-icon v-if="longitudeValidationFailure.length>0">
                                            warning
                                        </v-icon>
                                        {{longitudeValidationFailure}}
                                    </div>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <v-container>
                            <v-layout align-center column justify-center>
                                <v-btn
                                    dark
                                    color="success"
                                    :disabled="!valid"
                                    @click.stop="previewPoint()">
                                    Previsualiser le point
                                </v-btn>
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
    import ImagePoint from "./ImagePoint.vue";
    import LocationMapAdmin from "./LocationMapAdmin.vue";

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
                validationFailure: "",
                fkrefValidationFailure: "",
                titlesValidationFailure: "",
                descValidationFailure: "",
                linkAliasValidationFailure: "",
                lattitudeValidationFailure: "",
                longitudeValidationFailure: "",

                fk_cat: null,
                fk_ref: null,
                referenceList: [],
                selectedReference: null,// point : fk_reference_id
                selectedReferenceId: null,
                selectedColor: "",
                fk_id: [],
                titles: [],// pointname : title
                titlesInitial: [],
                desc: [],// pointname : description
                linkAlias: [],// pointname : linkalias
                codes:  [],// pointname : fk_language_id
                link: "",// point : link
                lattitude: null,// point : longitude
                longitude: null,// point : longitude
                lattitudeUpdater: null,
                longitudeUpdater: null,
                image: "",
                image_fk: "",// point : fk_image_id
                nameRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length <= 50) || "Trop long !"
                ],
                icon: '',
                iconTotal: '',

                pointPreview: {
                    icon: "",
                    color: "",
                    lat: null,
                    lng: null,
                    title: "",
                    desc: "",
                    link: "",
                    linkAlias: "",
                    img: "",
                },
                preview: false,

                snackbarLoading: false,
                snackText: "",
                snackbar: false,

                point: {
                    id: null,
                    link: "",
                    lattitude: null,
                    longitude: null,
                    fk_image_id: null,
                    fk_reference_id: null,
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
            titlesInitial(val, oldVal){
                // console.log("");
                // this.pageInit();
            },
            selectedReference(val, oldVal){
                this.setIcon(val);
            },  
            // Validation updaters :
                valid(){
                    this.validation();
                },
                fk_ref(){
                    this.validation();
                },
                titles(){
                    this.validation();
                },
                desc(){
                    this.validation();
                },
                link(){
                    this.validation();
                },
                linkAlias(){
                    this.validation();
                },
                lattitude(){
                    this.validation();
                },
                longitude(){
                    this.validation();
                },
            // END Validation updaters
        },
        methods: {
            pageInit(){
                console.log("");
                
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
                //used in create & edit mode
                this.setcodes();
            },
            editMode() {
                console.log("");
                //set name(s) :
                    for (let i = 0; i < this.pointsContents.length; i++) {
                        if (this.idSelected == this.pointsContents[i]["fk_point_id"]) {
                            for (let y = 0; y < this.languages.length; y++) {
                                if (this.pointsContents[i]["fk_language_code"] ==          this.languages[y]["code"]) {
                                    this.fk_id[y] = this.pointsContents[i]["id"];
                                    this.titles[y] = this.pointsContents[i]["title"];

                                    this.desc[y] = this.pointsContents[i]["description"];

                                    if (this.pointsContents[i]["linkalias"]) {
                                        this.linkAlias[y] = this.pointsContents[i]["linkalias"];
                                    }
                                    else{
                                        this.linkAlias[y] = "";
                                    }
                                }
                            }
                        }
                    }
                //search for fk_reference_id, fk_category_id & icon :
                        for (let x = 0; x < this.points.length; x++) {
                            if (this.idSelected == this.points[x]["id"]) { 
                                if (this.points[x]["link"]) {
                                    this.link = this.points[x]["link"];
                                }
                                else{
                                    this.link = "";
                                }
                                this.longitude = this.points[x]["longitude"];
                                this.lattitude = this.points[x]["lattitude"];
                                this.longitudeUpdater = this.points[x]["longitude"];
                                this.lattitudeUpdater = this.points[x]["lattitude"];
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
            setcodes(){
                //set languages codes
                for (let lang = 0; lang < this.languages.length; lang++) {
                    this.codes[lang] = this.languages[lang]["code"];
                }
            },
            setIcon(id) {
                //get icon from parent reference, then get icon color from parent category
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

            pageReinit(){
                console.log("");
                this.loading = true;
                // console.log("loading...");
                this.methodsApiCalls();
                this.titles = [];
                this.desc = [];
                this.linkAlias = [];
                this.link = "";
                this.selectedReference = null;
                // this.lattitude = null;
                // this.longitude = null;
                this.pageInit()
            },

            imageSelected(img) {    
                var images = JSON.parse(JSON.stringify(this.images));
                for (let image = 0; image < images.length; image++) {
                    if (img === images[image]["id"]) {
                        this.image = images[image]["image_path"];
                    }
                }
                this.image_fk = img;
            },
            clearImage(){
                this.image = "";
                this.image_fk = "";
            },
            imageListReload() {
                this.images = imagesMethods.readImages();
            },

            pointLattitudeUpdate(lattitude) {
                if (lattitude <= 44.590387 && lattitude >= 44.392567) {
                    this.lattitude = lattitude;
                    this.lattitudeUpdater = lattitude;
                }
                else{
                    this.lattitude = this.lattitude;
                    this.lattitudeUpdater = this.lattitude;
                }
            },
            pointLongitudeUpdate(longitude) {
                if (longitude <= 1.360224 && longitude >= 1.027538) {
                    this.longitude = longitude;
                    this.longitudeUpdater = longitude;
                }
                else{
                    this.longitude = this.longitude;
                    this.longitudeUpdater = this.longitude;
                }
            },

            previewPoint() {
                if (this.lattitude !== null && this.longitude !== null) {
                    var getFR;
                    
                    for (let lang = 0; lang < this.codes.length; lang++) {
                        if (this.codes[lang] == "fr") {
                            getFR = lang;
                        }
                    }
                    // var titles = JSON.parse(JSON.stringify(this.titles));
                    // console.log(titles);
                    this.pointPreview.icon = this.icon;
                    this.pointPreview.color = this.selectedColor;
                    
                    if (this.titles[getFR] !== "" && this.desc[getFR] !== "") {
                        this.pointPreview.lat =  this.lattitude;
                        this.pointPreview.lng = this.longitude;
                        this.pointPreview.title = this.titles[getFR];
                        this.pointPreview.desc = this.desc[getFR];

                        //Optional
                        if (this.linkAlias[getFR] !== "" && this.link !== "") {
                            this.pointPreview.link = this.link;
                            this.pointPreview.linkAlias = this.linkAlias[getFR];
                        }
                        else{
                        }

                        if (this.image_fk != null) {
                            this.pointPreview.img = this.image;
                        }
                        //END Optionnal
                        this.preview = !this.preview;
                    }
                    else{
                        console.log("fr title not set !");
                    }
                }
                else{
                    console.log("position not set !");
                }
            },

            validation() {
                //front validation
                var valid = true;
                var validationFailure = "Impossible de créer le point pour les raisons suivantes :  ";
                var titlesValidationFailure = "";
                var descValidationFailure = "";
                var linkAliasValidationFailure = "";
                var fkrefValidationFailure = "";
                var lattitudeValidationFailure = "";
                var longitudeValidationFailure = "";

                // Title
                    var missingTitle = false;
                    var errorTitle = false;
                    for (let title = 0; title < this.titles.length; title++) {
                        
                        if (this.titles[title].length == 0) {
                            missingTitle = true
                        }
                        if (this.titles[title].length > 50) {
                            errorTitle = true
                        }
                    }
                    if (missingTitle === true) {
                        valid = false;
                        validationFailure += " Au moins l'un des titres du point est manquant.";
                        titlesValidationFailure += "Au moins l'un des titres du point est manquant.";
                    }
                    if (errorTitle === true) {
                        valid = false;
                        validationFailure += " Au moins l'un des titres du point est invalide.";
                        titlesValidationFailure += "Au moins l'un des titres du point est invalide.";
                    }
                // END Title
                // Description
                    var missingDesc = false;
                    var errorDesc = false;
                    for (let d = 0; d < this.desc.length; d++) {
                        
                        if (this.desc[d].length == 0) {
                            missingDesc = true
                        }
                        if (this.desc[d].length > 50) {
                            errorDesc = true
                        }
                    }
                    if (missingDesc === true) {
                        valid = false;
                        validationFailure += " Au moins l'une des descriptions du point est manquante.";
                        descValidationFailure += "Au moins l'une des descriptions du point est manquante.";
                    }
                    if (errorDesc === true) {
                        valid = false;
                        validationFailure += " Au moins l'une des descriptions du point est invalide.";
                        descValidationFailure += "Au moins l'une des descriptions du point est invalide.";
                    }
                // END Description
                // Link
                    if (this.link !== "") {
                        var missingLink = false;
                        var errorLink = false;
                        for (let alias = 0; alias < this.linkAlias.length; alias++) {
                            if (this.linkAlias[alias].length == 0) {
                                missingLink = true;
                            }
                            if (this.linkAlias[alias].length > 50) {
                                errorLink = true;
                            }
                        }
                        if (missingLink === true) {
                            valid = false;
                            validationFailure += " Au moins l'un des textes du lien est manquant.";
                            linkAliasValidationFailure += "Au moins l'un des textes du lien est manquant.";
                        }
                        if (errorLink === true) {
                            valid = false;
                            validationFailure += " Au moins l'un des textes du lien est invalide.";
                            linkAliasValidationFailure += "Au moins l'un des textes du lien est invalide.";
                        }
                    }
                // END Link
                // Parent
                    if (this.fk_ref === null) {
                        valid = false;
                        validationFailure += " Référence parent non indiquée.";
                        fkrefValidationFailure += "Référence parent non indiquée.";
                    }
                // END Parent
                // Coord
                    if (this.lattitude === null) {
                        valid = false;
                        validationFailure += " Lattitude non renseignée.";
                        lattitudeValidationFailure += "Lattitude non renseignée.";
                    }
                    if (this.longitude === null) {
                        valid = false;
                        validationFailure += " Longitude non renseignée.";
                        longitudeValidationFailure += "Longitude non renseignée.";
                    }
                // END Coord

                if (valid == true) {
                    this.valid = true;
                    this.validationFailure = "";
                }
                else{
                    this.valid = false;
                    this.validationFailure = validationFailure;
                }

                this.titlesValidationFailure = titlesValidationFailure;
                this.descValidationFailure = descValidationFailure;
                this.linkAliasValidationFailure = linkAliasValidationFailure;
                this.fkrefValidationFailure = fkrefValidationFailure;
                this.lattitudeValidationFailure = lattitudeValidationFailure;
                this.longitudeValidationFailure = longitudeValidationFailure;
            },

            submit () {
                if (this.$refs.form.validate()) {

                    this.snackbarLoading = true;

                    // In create mode
                    if(this.page == "pointParent"){
                        this.createPoint();
                    }
                    // In edit mode
                    else if(this.page == "point"){
                        this.updatePoint(this.idSelected);
                        this.updatePointNames(this.fk_id);
                    }
                    // Error
                    else{
                        alert("Un problème est survenu lors de l'execution. Error located in EditReference.vue !");
                    };
                }
            },
            createPoint() {
                this.point.longitude = this.longitude;
                this.point.lattitude = this.lattitude;
                this.point.fk_reference_id = this.selectedReference;
                if (this.link !== "") {
                    this.point.link = this.link;
                }
                else{
                    this.point.link = "";
                }
                if (this.image_fk !== "") {
                    this.point.fk_image_id = this.image_fk;
                }
                else{
                    this.point.fk_image_id = "";
                }
                var newPoint = this.point;

                console.log("");

                axios.post('/api/points', newPoint)
                    .then(
                    resp =>
                        Promise.all([
                        resp,
                        console.log("")
                        ,
                        this.createPointNames(resp.data.id),
                        ])   
                    )
                    .catch(function (error) {
                        console.log(error.response.data);
                        
                        alert("Un problème est survenu lors de la création. Error located in EditPoint.vue !");
                    });
            },
            createPointNames(id) {
                
                for (let i = 0; i < this.codes.length; i++) {
                    var newPointName;
                    if (this.link !== "") {
                        newPointName = {
                            "fk_point_id": id,
                            "fk_language_code": this.codes[i],
                            "title": this.titles[i],
                            "description": this.desc[i],
                            "linkalias": this.linkAlias[i],
                        };
                    }
                    else {
                        newPointName = {
                            "fk_point_id": id,
                            "fk_language_code": this.codes[i],
                            "title": this.titles[i],
                            "description": this.desc[i],
                            "linkalias": "",
                        };
                    };

                    console.log("");
                    
                    axios.post('/api/pointsnames', newPointName)
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
                            
                            // alert("Un problème est survenu lors de la création. Error located in EditPoint.vue !");
                            this.failed(error, "Erreur lors de la création du point !");
                        });
                }
            },
            updatePoint(id) {
                this.point.longitude = this.longitude;
                this.point.lattitude = this.lattitude;
                this.point.fk_reference_id = this.selectedReference;
                if (this.link !== "") {
                    this.point.link = this.link;
                }
                else{
                    this.point.link = "";
                }
                if (this.image_fk !== "") {
                    this.point.fk_image_id = this.image_fk;
                }
                else{
                    this.point.fk_image_id = "";
                }
                var newPoint = this.point;

                console.log("");
                
                axios.patch('/api/points/' + id, newPoint)
                    .then(function (resp) {
                        console.log("");
                        
                    })
                    .catch(function (error) {
                        console.log(error.response.data);
                        
                        alert("Un problème est survenu lors de la mise à jour. Error located in EditPoint.vue !");
                    });
                // this.$emit('pageToShow', "", null);
            },
            updatePointNames(id) {
                for (let i = 0; i < this.codes.length; i++) {
                    var newPointName;
                    if (this.link !== "") {
                        newPointName = {
                            "fk_point_id": this.idSelected,
                            "fk_language_code": this.codes[i],
                            "title": this.titles[i],
                            "description": this.desc[i],
                            "linkalias": this.linkAlias[i],
                        };
                    }
                    else {
                        newPointName = {
                            "fk_point_id": this.idSelected,
                            "fk_language_code": this.codes[i],
                            "title": this.titles[i],
                            "description": this.desc[i],
                            "linkalias": "",
                        };
                    };

                    console.log("");
                    
                    axios.patch('/api/pointsnames/' + id[i], newPointName)
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
                            
                            // alert("Un problème est survenu lors de la mise à jour. Error located in EditPoint.vue !");
                            this.failed(error, "Erreur lors de la mise à jour du point !");
                        });
                }
                // this.$emit('pageToShow', "", null);
            },

            success(response, msg) {
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = msg;
                this.$emit('pageToShow', "", null);
            },
            failed(error) {
                console.log(error);
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = msg;
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
                        // this.loading = false;
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
        },
        components: {
            ImagePoint,
            LocationMapAdmin
        }
    }
</script>

<style scoped>
    .listColorAlt{
        background-color: #C8E6C9 !important;
    }
    .highlightHeader:hover{
        background-color: #81C784 !important;
    }
    /* .separator:before {
        content:'';
        position:absolute;
        width:100%;
        height:3px;
        background:linear-gradient(to left, rgba(0, 0, 0, 0), #AED581, rgba(0, 0, 0, 0));
        top:0px;
        left:0;
    } */
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
    .selectedImg {
        padding: 40px;
        background-color: rgb(82, 196, 82);
    }
</style>