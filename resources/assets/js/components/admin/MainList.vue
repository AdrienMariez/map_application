<template>
    <div>
    <!-- Create new category button -->
        <v-list>
            <v-btn
                color="success"
                @click="editCategory(null)">
                <!-- editCategory is used as the result is exactly the same. -->
                <v-icon>add</v-icon> Ajouter catégorie
            </v-btn> 
        </v-list>

    <!-- Main list -->
        <v-expansion-panel
            expand>
            <!-- loop on categories -->
            <v-expansion-panel-content
                v-for="(category,i) in categories"
                :key="i"
                color="green lighten-3"
                class="green lighten-3">

                <!-- category header -->
                <div class="headerCategories" slot="header">
                    <v-list
                        color="transparent"
                        class="transparent">
                            <v-list-tile>
                                <v-list-tile-action>
                                    <v-icon
                                        v-bind:style="{ color: category.color }">
                                        {{category.icon}}
                                    </v-icon>
                                </v-list-tile-action>

                                <v-list-tile-action>
                                    <!-- loop on names in categories & translations -->
                                    <v-list-tile-content
                                        v-for="(catName,a) in categoriesNames"
                                        v-if="catName.fk_language_code == languageSelected && catName.fk_category_id == category.id"
                                        :key="a">
                                        {{catName.text}}
                                    </v-list-tile-content>
                                </v-list-tile-action>
                            </v-list-tile>
                    </v-list>
                </div>

                <!-- categories desktop buttons -->
                <v-list
                    xs12
                    color="green lighten-3"
                    class="hidden-sm-and-down green lighten-3">
                    <v-layout align-center justify-space-around>
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
                    </v-layout>
                </v-list>

                <!-- categories responsive buttons -->
                        <v-list
                            color="green lighten-3"
                            class="hidden-md-and-up green lighten-3">
                            <v-layout align-center justify-space-around>
                                <v-btn
                                    color="success"
                                    @click="createReference(category.id)">
                                    <v-icon>add</v-icon>
                                </v-btn>
                                <v-btn
                                    color="warning"
                                    @click="editCategory(category.id)">
                                    <v-icon>build</v-icon>
                                 </v-btn>
                                <v-btn
                                    color="error"
                                    @click="deleteCategory(category.id)">
                                     <v-icon>delete</v-icon>
                                </v-btn>
                            </v-layout>
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
                        <div  class="headerReferences" slot="header">
                            <v-list
                                color="transparent"
                                class="transparent">
                                    <v-list-tile>
                                        <v-list-tile-action>
                                            <v-icon
                                                v-bind:style="{ color: category.color }">
                                                {{reference.icon}}
                                            </v-icon>
                                        </v-list-tile-action>

                                        <v-list-tile-action>
                                            <!-- loop on names in references & translations -->
                                            <v-list-tile-content
                                                v-for="(refName,b) in referenceNames"
                                                v-if="refName.fk_language_code == languageSelected && refName.fk_reference_id == reference.id"
                                                :key="b">{{refName.text}}
                                            </v-list-tile-content>
                                        </v-list-tile-action>
                                    </v-list-tile>
                            </v-list>
                        </div>

                        <!-- references desktop buttons -->
                        <v-list
                            color="green lighten-4"
                            class="hidden-sm-and-down green lighten-4">
                            <v-layout align-center justify-space-around>
                                <v-btn
                                    color="success"
                                    @click="createPoint(reference.id)">
                                    ajouter point
                                </v-btn>                                 <v-btn
                                    color="warning"
                                    @click="editReference(reference.id)">
                                    modifier
                                </v-btn>
                                <v-btn
                                    color="error"
                                    @click="deleteReference(reference.id)">
                                    supprimer
                                </v-btn>
                            </v-layout>
                        </v-list>

                        <!-- references responsive button -->
                        <v-list
                            color="green lighten-4"
                            class="hidden-md-and-up green lighten-4">
                            <v-layout align-center justify-space-around>
                                <v-btn
                                    color="success"
                                    @click="createPoint(reference.id)">
                                    <v-icon>add</v-icon>
                                </v-btn>                                       <v-btn
                                    color="warning"
                                    @click="editReference(reference.id)">
                                    <v-icon>build</v-icon>
                                </v-btn>
                                <v-btn
                                    color="error"
                                    @click="deleteReference(reference.id)">
                                    <v-icon>delete</v-icon>
                                </v-btn>
                            </v-layout>
                        </v-list>
                        <!-- <v-menu
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
                        </v-menu> -->

                        <!-- loop on points in references -->
                        <v-list
                            v-for="(point,z) in points"
                            v-if="point.fk_reference_id == reference.id"
                            :key="z"
                            color="white"
                            class="white pointsListElement">
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
                                            <v-list-tile-content
                                                v-for="(pointName,c) in pointsContents"
                                                v-if="pointName.fk_language_code == languageSelected && pointName.fk_point_id == point.id"
                                                :key="c">
                                                {{pointName.title}}
                                            </v-list-tile-content>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </v-expansion-panel-content>
                </v-expansion-panel>

            </v-expansion-panel-content>
        </v-expansion-panel>

    <!-- Alert in case of imminent destroy -->
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

    <!-- Message in case of impossible action -->
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
    import pointsMethods from './../../services/points.js'
    import categoriesMethods from './../../services/categories.js'
    import referencesMethods from './../../services/references.js'

  export default {
    data () {
      return {
        points: [],
        pointsContents: [],
        languageSelected: 'fr',
        categories: [],
        categoriesNames: [],
        references: [],
        referenceNames: [],
        snackbar: false,
        snackText: '',
        dialog: false,
        dialogText: '',
        dialogId: null,
        dialogType: '',
        working: false,
        readonly: false,
      }
    },
    watch: {
    },
    methods: {
        //API CALLS
            methodsApiCalls() {
                this.categories = categoriesMethods.readCategories();
                this.categoriesNames = categoriesMethods.readCategoriesNames();
                this.references = referencesMethods.readReferences();
                this.referenceNames = referencesMethods.readReferenceNames();
                this.points = pointsMethods.readPoints();
                this.pointsContents = pointsMethods.readPointsPopupContent();
            },
        //
        //EDIT CATEGORIES
            editCategory(id){
                this.$emit('pageToShow', "category", id);
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
                    if (this.categoriesNames[y]["fk_category_id"] == idCategory && this.categoriesNames[y]["fk_language_code"] == this.languageSelected) {
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
                this.$emit('pageToShow', "referenceParent", id);
            },
        //EDIT REFERENCE
            editReference(id){
                this.$emit('pageToShow', "reference", id);
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
                    if (this.referenceNames[y]["fk_reference_id"] == idReference && this.referenceNames[y]["fk_language_code"] == this.languageSelected) {
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
                this.$emit('pageToShow', "pointParent", id);
            },
        //EDIT POINT
            editPoint(id){
                this.$emit('pageToShow', "point", id);
            },
        //DELETE POINT
            deletePoint(idPoint){
                var idName = '';
                for (let y = 0; y < this.pointsContents.length; y++) {
                    if (this.pointsContents[y]["fk_point_id"] == idPoint && this.pointsContents[y]["fk_language_code"] == this.languageSelected) {
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
                if (type == "category") {
                    categoriesMethods.destroyCategory(id);
                    for (let i = 0; i < this.categoriesNames.length; i++) {
                        
                        if (this.categoriesNames[i]["fk_category_id"] == id) {

                            categoriesMethods.destroyCategoryName(this.categoriesNames[i]["id"]);
                        }
                    }
                    //reload categories list
                    //mimics a reload
                    this.categories = [];
                    this.categories = categoriesMethods.readCategories();
                    this.categoriesNames = [];
                    this.categoriesNames = categoriesMethods.readCategoriesNames();
                }
                else if (type == "reference") {
                    referencesMethods.destroyReference(id);
                    for (let i = 0; i < this.referenceNames.length; i++) {
                        
                        if (this.referenceNames[i]["fk_reference_id"] == id) {

                            referencesMethods.destroyReferenceName(this.referenceNames[i]["id"]);
                        }
                    }
                    //reload references list
                    //mimics a reload
                    this.references = [];
                    this.references = referencesMethods.readReferences();
                    this.referenceNames = [];
                    this.referenceNames = referencesMethods.readReferenceNames();
                }
                else if (type == "point") {
                    pointsMethods.destroyPoint(id);
                }else{
                    console.log("If we get here, we are in trouble as the method does not know what it is supposed to remove.");
                    alert("Un problème est survenu lors de la suppression. Error located in MainList.vue !");
                }
            },
    },
    created() {
        this.methodsApiCalls();
    },
  }
</script>

<style scoped>
    .v-expansion-panel__container{
        border-top: none !important;
    }
    .headerCategories{
        padding-left: 0px;
    }
    .headerReferences{
        padding-left: 10px;
    }
    @media screen and (min-width: 600px) {
        .headerReferences{
            padding-left: 30px;
        }
    }
    .pointsListElement{
        padding-left: 80px;        
    }

    /* .v-snack--bottom{
        bottom: 50px;
    } */
</style>