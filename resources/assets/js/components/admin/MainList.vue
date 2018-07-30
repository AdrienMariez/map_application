<template>
    <div>
        <v-expansion-panel
            expand>
            <!-- loop on categories -->
            <v-expansion-panel-content
                v-for="(category,i) in categories"
                :key="i"
                color="green lighten-3"
                class="green lighten-3">

                <!-- category header -->
                <div slot="header">
                    <v-list
                        color="transparent"
                        class="transparent">
                            <v-list-tile>
                                <v-menu
                                        right
                                        class="hidden-md-and-up">
                                        <v-btn
                                            slot="activator"
                                            icon>
                                            <v-icon>build</v-icon>
                                        </v-btn>
                            
                                        <v-list>
                                            <v-btn
                                                color="success"
                                                @click="createReference(category.id)">
                                                ajouter réference
                                            </v-btn>  
                                            <v-btn
                                                color="warning"
                                                @click="editCategory(category.id)">
                                                modifier
                                            </v-btn>
                                            <v-btn
                                                color="error"
                                                @click="deleteCategory(category.id)">
                                                supprimer
                                            </v-btn>
                                        </v-list>
                                </v-menu>

                                <v-list-tile-action>
                                    <v-icon
                                        v-bind:style="{ color: category.color }">
                                        fa-{{category.icon}}
                                    </v-icon>
                                </v-list-tile-action>

                                <v-list-tile-action>
                                    <!-- loop on names in categories & translations -->
                                    <v-list-tile-content
                                        v-for="(catName,a) in categoriesNames"
                                        v-if="catName.fk_language_id == languageSelected && catName.fk_category_id == category.id"
                                        :key="a">
                                        {{catName.text}}
                                    </v-list-tile-content>
                                </v-list-tile-action>
                            </v-list-tile>
                    </v-list>
                </div>

                <!-- category desktop buttons -->
                <v-list
                    color="green lighten-3"
                    class="hidden-sm-and-down green lighten-3">
                    <v-btn
                        color="success"
                        @click="createReference(category.id)">
                        ajouter référence
                    </v-btn>   
                    <v-btn
                        color="warning"
                        @click="editCategory(category.id)">
                        modifier
                    </v-btn>
                    <v-btn
                        color="error"
                        @click="deleteCategory(category.id)">
                       supprimer
                    </v-btn>
                </v-list>

                <!-- loop on references in categories -->
                <v-expansion-panel
                    expand>
                    <!-- loop on references -->
                    <v-expansion-panel-content
                        v-for="(reference,y) in references"
                        v-if="reference.fk_category_id == category.id"
                        :key="y"
                        color="green lighten-4"
                        class="green lighten-4">

                        <!-- reference header -->
                        <div slot="header">
                            <v-list
                                color="transparent"
                                class="transparent">
                                    <v-list-tile>
                                        <v-menu
                                                right
                                                class="hidden-md-and-up">
                                                <v-btn
                                                    slot="activator"
                                                    icon>
                                                    <v-icon>build</v-icon>
                                                </v-btn>
                                    
                                                <v-list>
                                                    <v-btn
                                                        color="success"
                                                        @click="createPoint(reference.id)">
                                                        ajouter point
                                                    </v-btn>
                                                    <v-btn
                                                        color="warning"
                                                        @click="editReference(reference.id)">
                                                        modifier
                                                    </v-btn>
                                                    <v-btn
                                                        color="error"
                                                        @click="deleteReference(reference.id)">
                                                        supprimer
                                                    </v-btn>
                                                </v-list>
                                        </v-menu>

                                        <v-list-tile-action>
                                            <v-icon
                                                v-bind:style="{ color: category.color }">
                                                fa-{{reference.icon}}
                                            </v-icon>
                                        </v-list-tile-action>

                                        <v-list-tile-action>
                                            <!-- loop on names in references & translations -->
                                            <v-list-tile-content
                                                v-for="(refName,b) in referenceNames"
                                                v-if="refName.fk_language_id == languageSelected && refName.fk_reference_id == reference.id"
                                                :key="b">
                                                {{refName.fk_reference_id}} - 
                                                {{refName.text}}
                                            </v-list-tile-content>
                                        </v-list-tile-action>
                                    </v-list-tile>
                            </v-list>
                        </div>

                        <!-- reference desktop buttons -->
                        <v-list
                            color="green lighten-4"
                            class="hidden-sm-and-down green lighten-4">
                            <v-btn
                                color="success"
                                @click="createPoint(reference.id)">
                                ajouter point
                            </v-btn>                                       <v-btn
                                color="warning"
                                @click="editReference(reference.id)">
                                modifier
                            </v-btn>
                            <v-btn
                                color="error"
                                @click="deleteReference(reference.id)">
                                supprimer
                            </v-btn>
                        </v-list>

                        <!-- loop on points in references -->
                        <v-list
                            v-for="(point,z) in points"
                            v-if="point.fk_reference_id == reference.id"
                            :key="z"
                            color="white"
                            class="white">
                            <v-list-tile>
                                <v-list-tile-action>
                                            <v-menu right>
                                                <v-btn
                                                    slot="activator"
                                                    icon>
                                                    <v-icon>build</v-icon>
                                                </v-btn>
                                    
                                                <v-list>
                                                    <v-btn
                                                        color="warning"
                                                        @click="editPoint(point.id)">
                                                        modifier
                                                    </v-btn>
                                                    <v-btn
                                                        color="error"
                                                        @click="deletePoint(point.id)">
                                                        supprimer
                                                    </v-btn>
                                                </v-list>
                                            </v-menu>
                                </v-list-tile-action>

                                <v-list-tile-action>
                                            <!-- loop on names in points & translations -->
                                            <v-list-tile-content>
                                                {{point.id}} - 
                                                {{point.icon}}
                                            </v-list-tile-content>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </v-expansion-panel-content>
                </v-expansion-panel>

            </v-expansion-panel-content>
        </v-expansion-panel>

        <v-layout row justify-center>
            <v-dialog v-model="dialog" persistent max-width="290">
                <v-card>
                            <v-card-title class="headline">
                                {{dialogText}}
                            </v-card-title>
                            <v-card-text>
                                Cette suppression sera irreversible à partir de l'acceptation de cette boîte de dialogue.
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="green darken-1"
                                    flat
                                    @click.native="
                                        dialog = false,
                                        dialogId = null,
                                        dialogType = ''">
                                    Annuler
                                </v-btn>
                                <v-btn
                                    color="green darken-1"
                                    flat
                                    @click.native="
                                        destroy(dialogType,dialogId)
                                        dialog = false,
                                        dialogId = null,
                                        dialogType = ''">
                                    Supprimer
                                </v-btn>
                            </v-card-actions>
                </v-card>
            </v-dialog>
        </v-layout>

        <v-snackbar
            v-model="snackbar"
            :bottom="snackY === 'bottom'"
            :right="snackX === 'right'"
            :multi-line="mode === 'multi-line'"
            :timeout="snackTimeout"
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
    //Needed for promises to work
        function Language({ id, name, code}) {
            this.id = id;
            this.name = name;
            this.code = code;
        }
        function Category({ id, icon, color, weight}) {
            this.id = id;
            this.icon = icon;
            this.color = color;
            this.weight = weight;
        }
        function CategoryName({ id, fk_category_id, fk_language_id, text}) {
            this.id = id;
            this.fk_category_id = fk_category_id;
            this.fk_language_id = fk_language_id;
            this.text = text;
        }
        function Reference({ id, icon, color, weight, fk_category_id}) {
            this.id = id;
            this.icon = icon;
            this.color = color;
            this.weight = weight;
            this.fk_category_id = fk_category_id;
        }
        function ReferenceName({ id, fk_reference_id, fk_language_id, text}) {
            this.id = id;
            this.fk_reference_id = fk_reference_id;
            this.fk_language_id = fk_language_id;
            this.text = text;
        }
        function Point({ id, link, icon, color, longitude, lattitude, image_path, fk_reference_id}) {
            this.id = id;
            this.link = link;
            this.icon = icon;
            this.color = color;
            this.longitude = longitude;
            this.lattitude = lattitude;
            this.image_path = image_path;
            this.fk_reference_id = fk_reference_id;
        }
        function PointName({ id, fk_point_id, fk_language_id, title, description, linkalias}) {
            this.id = id;
            this.fk_point_id = fk_point_id;
            this.fk_language_id = fk_language_id;
            this.title = title;
            this.description = description;
            this.linkalias = linkalias;
        }
    //END Needed for promises to work

  export default {
    data () {
      return {
        points: [],
        pointsContents: [],
        languages: [],
        languageSelected: 0,
        categories: [],
        categoriesNames: [],
        references: [],
        referenceNames: [],
        snackbar: false,
        snackY: 'bottom',
        snackX: 'right',
        mode: 'multi-line',
        snackTimeout: 6000,
        snackText: '',
        dialog: false,
        dialogText: '',
        dialogId: null,
        dialogType: '',
        working: false,
      }
    },
    watch: {
        languages(val, oldVal){
            this.SetAdminLanguage();
        },
        languageSelected(val, oldVal) {
            this.languageSelected = val
            this.emitLanguage();
        }
    },
    methods: {
        //ON START FIND FRENCH LANGUAGE
            SetAdminLanguage() {
                var languageCode = window.navigator.userLanguage || window.navigator.language;
                // var languageCode = "de-AT";
                var language = languageCode.substring(0,2);
                var languages = JSON.parse(JSON.stringify(this.languages));
                var languageFrench = null;
                var languageBackup = null;

                languages.forEach(lang => {   
                        if (lang["code"] == "fr") {
                            languageFrench = lang["id"];
                        }
                        else{
                            languageBackup = lang["id"];
                        }
                });
                if (languageFrench == null) {
                        // if french isn't found, fall back to any other language last created.
                        languageFrench = languageBackup;
                }
                    
                this.languageSelected = languageFrench;
            },
        //POINTS READ
            readPoints() {
                this.mute = true;
                window.axios.get('/api/points').then(({ data }) => {
                data.forEach(point => {
                    //loops over each point in db
                    // console.log("point :");
                    // console.log(point);
                    this.points.push(new Point(point));
                });
                this.mute = false;
                });
            },
        //POINTS CONTENTS READ
            readPointsPopupContent() {
                this.mute = true;
                
                window.axios.get('/api/pointsnames').then(({ data }) => {
                data.forEach(pointContent => {
                    this.pointsContents.push(new PointName(pointContent));
                });
                this.mute = false;
                });
            },
        //REFERENCES READ
            readReferences() {
                this.mute = true;
                window.axios.get('/api/references').then(({ data }) => {
                data.forEach(reference => {
                    //loops over each reference in db
                    // console.log("reference :");
                    // console.log(reference);
                    this.references.push(new Reference(reference));
                    // var obj = {};
                    // obj["id"] = reference.id;
                    // obj["isToBeDisplayed"] = false;
                    // obj["catColor"] = "";
                    // this.referenceDisplayed.push(obj);
                });
                this.mute = false;
                });
            },
        //REFERENCE NAMES READ
            readReferenceNames() {
                this.mute = true;
                window.axios.get('/api/referencesnames').then(({ data }) => {
                data.forEach(referenceName => {
                    //loops over each reference name in db
                    // console.log("reference name :");
                    // console.log(referenceName);
                    this.referenceNames.push(new ReferenceName(referenceName));
                });
                this.mute = false;
                });
            },
        //CATEGORIES READ
            readCategories() {
                this.mute = true;
                window.axios.get('/api/categories').then(({ data }) => {
                data.forEach(category => {
                    //loops over each category in db
                    // console.log("category :");
                    // console.log(category);
                    this.categories.push(new Category(category));
                });
                this.mute = false;
                });
            },
        //CATEGORIES NAMES READ
            readCategoriesNames() {
                this.mute = true;
                window.axios.get('/api/categoriesnames').then(({ data }) => {
                data.forEach(categoryName => {
                    //loops over each category name in db
                    // console.log("category name :");
                    // console.log(categoryName);
                    this.categoriesNames.push(new CategoryName(categoryName));
                    
                });
                this.mute = false;
                });
            },
        //LANGUAGES READ
            readLanguages() {
                this.mute = true;
                window.axios.get('/api/languages').then(({ data }) => {
                data.forEach(language => {
                    //loops over each language in db
                    // console.log("language :");
                    // console.log(language);
                    this.languages.push(new Language(language));
                    
                });
                this.mute = false;
                });
            },
        //
        //EDIT CATEGORIES
            editCategory(id){
                console.log("go edit category "+ id);
            },
        //DELETE CATEGORIES
            deleteCategory(idCategory){
                var referencesCorresponding = 0;
                //create empty var
                for (let i = 0; i < this.references.length; i++) {
                    if (this.references[i]["fk_category_id"] == idCategory){
                        referencesCorresponding++;
                        //increment var each time a child is found
                    }
                }
                var idName = '';
                for (let y = 0; y < this.categoriesNames.length; y++) {
                    if (this.categoriesNames[y]["fk_category_id"] == idCategory && this.categoriesNames[y]["fk_language_id"] == this.languageSelected) {
                        idName = this.categoriesNames[y]["text"]
                    }
                }
                if (idName.length == 0) {
                    idName = "[Pas de nom référencé pour cet élément]";
                }

                if (referencesCorresponding == 0) {
                    //if no child found, can remove
                    this.dialogId = idCategory,
                    this.dialogType = 'category',
                    this.dialogText = 'Veuillez confirmer la suppression de '+idName+' with id: '+this.dialogId+' of type: '+this.dialogType,
                    this.dialog = true;
                }
                else{
                    //if child found, prevent remove
                    this.snackText = 'Impossible de supprimer la catégorie '+idName+' tant que des éléments y sont inclus.',
                    this.snackbar = true;
                }
            },
        //CREATE REFERENCE
            createReference(id){
                console.log("go create reference under category "+ id);
            },
        //EDIT REFERENCE
            editReference(id){
                console.log("go edit reference "+ id);
            },
        //DELETE REFERENCE
            deleteReference(idReference){
                var pointsCorresponding = 0;
                //create empty var
                for (let i = 0; i < this.points.length; i++) {
                    if (this.points[i]["fk_reference_id"] == idReference){
                        pointsCorresponding++;
                        //increment var each time a child is found
                    }
                }
                var idName = '';
                for (let y = 0; y < this.referenceNames.length; y++) {
                    if (this.referenceNames[y]["fk_reference_id"] == idReference && this.referenceNames[y]["fk_language_id"] == this.languageSelected) {
                        idName = this.referenceNames[y]["text"]
                    }
                }
                if (idName.length == 0) {
                    idName = "[Pas de nom référencé pour cet élément]";
                }

                if (pointsCorresponding == 0) {
                    //if no child found, can remove
                    this.dialogId = idReference,
                    this.dialogType = 'reference',
                    //TO CHANGE too much info in dialogText
                    this.dialogText = 'Veuillez confirmer la suppression de '+idName+' with id: '+this.dialogId+' of type: '+this.dialogType,
                    this.dialog = true;
                }
                else{
                    //if child found, prevent remove
                    this.snackText = 'Impossible de supprimer la référence '+idName+' tant que des éléments y sont inclus.',
                    this.snackbar = true;
                }
            },
        //CREATE POINT
            createPoint(id){
                console.log("go create point under reference "+ id);
            },
        //EDIT POINT
            editPoint(id){
                console.log("go edit point "+ id);
            },
        //DELETE POINT
            deletePoint(idPoint){
                var idName = '';
                for (let y = 0; y < this.pointsContents.length; y++) {
                    if (this.pointsContents[y]["fk_point_id"] == idPoint && this.pointsContents[y]["fk_language_id"] == this.languageSelected) {
                        idName = this.pointsContents[y]["title"]
                    }
                }
                if (idName.length == 0) {
                    idName = "[Pas de nom référencé pour cet élément]";
                }

                    //if no child found, can remove
                    this.dialogId = idPoint,
                    this.dialogType = 'point',
                    this.dialogText = 'Veuillez confirmer la suppression de '+idName+' with id: '+this.dialogId+' of type: '+this.dialogType,
                    this.dialog = true;
            },
        //DESTROY HUB
            destroy(type,id){
                console.log("type :"+type+"/ id :"+id);
                if (type == "category") {
                    this.destroyCategory(id);
                }
                else if (type == "reference") {
                    this.destroyReference(id);
                }
                else if (type == "point") {
                    this.destroyPoint(id);
                }else{}
            },
        //DESTROY CATEGORY
            destroyCategory(id){
                this.$emit('pageToShow', "category", id);
            },
        //DESTROY REFERENCE
            destroyReference(id){
                this.$emit('pageToShow', "reference", id);
            },
        //DESTROY POINT
            destroyPoint(id){
                this.$emit('pageToShow', "point", id);
            },
    },
    created() {
        this.readReferenceNames();
        this.readPoints();
        this.readPointsPopupContent();
        this.readReferences();
        this.readCategories();
        this.readLanguages();
        this.readCategoriesNames();
    },
  }
</script>

<style scoped>
    .v-expansion-panel__container{
        border-top: none !important;
    }
    .v-snack--bottom{
        bottom: 50px;
    }
</style>