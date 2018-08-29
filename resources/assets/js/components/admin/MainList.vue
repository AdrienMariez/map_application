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
            expand
            class="mainList">
            <!-- loop on categories -->
            <v-expansion-panel-content
                v-for="(category,i) in categories"
                :key="i"
                color="green lighten-3"
                class="green lighten-3">

                <!-- category header -->
                <div class="headerCategories" slot="header">
                    <div class="borderCategories"></div>
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
                        <v-btn
                            v-if="i !== 0"
                            color="info"
                            @click="moveCatUp(category.id)">
                            <v-icon>arrow_upward</v-icon>
                        </v-btn>
                        <v-btn
                            v-if="i !== categories.length-1"
                            color="info"
                            @click="moveCatDown(category.id)">
                            <v-icon>arrow_downward</v-icon>
                        </v-btn>
                    </v-layout>
                </v-list>

                <!-- categories responsive buttons -->
                <v-list
                    color="green lighten-3"
                    class="hidden-md-and-up green lighten-3">
                    <v-layout align-center justify-space-around>
                        <v-btn
                            small
                            color="success"
                            @click="createReference(category.id)">
                            <v-icon>add</v-icon>
                        </v-btn>
                        <v-btn
                            small
                            color="warning"
                            @click="editCategory(category.id)">
                            <v-icon>build</v-icon>
                        </v-btn>
                        <v-btn
                            small
                            color="error"
                            @click="deleteCategory(category.id)">
                            <v-icon>delete</v-icon>
                        </v-btn>
                        <v-btn
                            small
                            v-if="i !== 0"
                            color="info"
                            @click="moveCatUp(category.id)">
                            <v-icon>arrow_upward</v-icon>
                        </v-btn>
                        <v-btn
                            small
                            v-if="i !== categories.length-1"
                            color="info"
                            @click="moveCatDown(category.id)">
                            <v-icon>arrow_downward</v-icon>
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
                            <div class="borderReferences"></div>
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
                                </v-btn>                                <v-btn
                                    color="warning"
                                    @click="editReference(reference.id)">
                                    modifier
                                </v-btn>
                                <v-btn
                                    color="error"
                                    @click="deleteReference(reference.id)">
                                    supprimer
                                </v-btn>
                                <v-btn
                                    color="info"
                                    @click="moveRefUp(reference.id)">
                                    <v-icon>arrow_upward</v-icon>
                                </v-btn>
                                <v-btn
                                    color="info"
                                    @click="moveRefDown(reference.id)">
                                    <v-icon>arrow_downward</v-icon>
                                </v-btn>
                            </v-layout>
                        </v-list>

                        <!-- references responsive button -->
                        <v-list
                            color="green lighten-4"
                            class="hidden-md-and-up green lighten-4">
                            <v-layout align-center justify-space-around>
                                <v-btn
                                    small
                                    color="success"
                                    @click="createPoint(reference.id)">
                                    <v-icon>add</v-icon>
                                </v-btn>                     <v-btn
                                    small
                                    color="warning"
                                    @click="editReference(reference.id)">
                                    <v-icon>build</v-icon>
                                </v-btn>
                                <v-btn
                                    small
                                    color="error"
                                    @click="deleteReference(reference.id)">
                                    <v-icon>delete</v-icon>
                                </v-btn>
                                <v-btn
                                    small
                                    color="info"
                                    @click="moveRefUp(reference.id)">
                                    <v-icon>arrow_upward</v-icon>
                                </v-btn>
                                <v-btn
                                    small
                                    color="info"
                                    @click="moveRefDown(reference.id)">
                                    <v-icon>arrow_downward</v-icon>
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
                                        <!-- points desktop buttons -->
                                        <v-list class="hidden-sm-and-down">
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
                                        <!-- points responsive buttons -->
                                        <v-list class="hidden-md-and-up">
                                            <v-btn
                                                small
                                                color="warning"
                                                @click="editPoint(point.id)">
                                                <v-icon>build</v-icon>
                                            </v-btn>
                                            <v-btn
                                                small
                                                color="error"
                                                @click="deletePoint(point.id)">
                                                <v-icon>delete</v-icon>
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
            <v-dialog v-model="dialog" persistent>
                <v-card>
                            <v-card-text class="headline text-xs-center">
                                {{dialogText}}
                            </v-card-text>
                            <v-card-text class="text-xs-center">
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
                                        dialogType = ''"
                                    >
                                    <v-icon>keyboard_backspace</v-icon>
                                    Retour
                                </v-btn>
                                <v-btn
                                    color="error"
                                    flat
                                    @click.native="
                                        destroy(dialogType,dialogId)
                                        dialog = false,
                                        dialogId = null,
                                        dialogType = ''"
                                    >
                                    <v-icon>delete</v-icon>
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
        //MOVE CAT UP
            moveCatUp(id) {
                for (let cat = 0; cat < this.categories.length; cat++) {
                    if (this.categories[cat]["id"] === id) {
                        //if previous exists
                        if (this.categories[cat-1]) {
                            var PreviousCatId = this.categories[cat-1]["id"]

                            var editPreviousCat = {
                                "icon": this.categories[cat-1]["icon"],
                                "color": this.categories[cat-1]["color"],
                                "weight": this.categories[cat]["weight"]
                            };
                            var editCurrentCat = {
                                "icon": this.categories[cat]["icon"],
                                "color": this.categories[cat]["color"],
                                "weight": this.categories[cat-1]["weight"]
                            };

                            axios.patch('/api/categories/' + id, editCurrentCat)
                                .then(function (resp) {
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in MainList.vue !");
                                });

                            axios.patch('/api/categories/' + PreviousCatId, editPreviousCat)
                                .then(response => { 
                                    this.categoriesSuccess(response, "Modification effectuée !");
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in MainList.vue !");
                                });

                        }
                    }
                }
            },
        //MOVE CAT DOWN
            moveCatDown(id) {
                for (let cat = 0; cat < this.categories.length; cat++) {
                    if (this.categories[cat]["id"] === id) {
                        //if next exists
                        if (this.categories[cat+1]) {

                            var NextCatId = this.categories[cat+1]["id"]

                            var editNextCat = {
                                "icon": this.categories[cat+1]["icon"],
                                "color": this.categories[cat+1]["color"],
                                "weight": this.categories[cat]["weight"]
                            };
                            var editCurrentCat = {
                                "icon": this.categories[cat]["icon"],
                                "color": this.categories[cat]["color"],
                                "weight": this.categories[cat+1]["weight"]
                            };

                            axios.patch('/api/categories/' + id, editCurrentCat)
                                .then(function (resp) {
                                    console.log("current edited");
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in MainList.vue !");
                                });

                            axios.patch('/api/categories/' + NextCatId, editNextCat)
                                .then(response => { 
                                    this.categoriesSuccess(response, "Modification effectuée !");
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in MainList.vue !");
                                });
                        }
                    }
                }
            },
        // CATEGORIES SUCCESS
            categoriesSuccess(response, msg) {
                this.snackbar = true;
                this.snackText = msg;
                this.categories = [];
                this.categories = categoriesMethods.readCategories();
            },
        //MOVE REF UP
            moveRefUp(id) {
                // Search for the parent category
                var ParentCategory;
                for (let ref = 0; ref < this.references.length; ref++) {
                    if (this.references[ref]["id"] === id) {
                        ParentCategory = this.references[ref]["fk_category_id"];
                        break;
                    }
                }
                // Search for all others references belonging to this parent
                var refTable = [];
                for (let ref = 0; ref < this.references.length; ref++) {
                    if (this.references[ref]["fk_category_id"] == ParentCategory) {
                        refTable.push(this.references[ref]);
                    }
                }

                // Now to make it work

                for (let ref = 0; ref < refTable.length; ref++) {
                    if (refTable[ref]["id"] === id) {
                        // If previous exists
                        if (refTable[ref-1]) {
                            var previousRefId = refTable[ref-1]["id"]

                            var editPreviousRef = {
                                "icon": refTable[ref-1]["icon"],
                                "weight": refTable[ref]["weight"],
                                "fk_category_id": refTable[ref-1]["fk_category_id"]
                            };
                            var editCurrentRef = {
                                "icon": refTable[ref]["icon"],
                                "weight": refTable[ref-1]["weight"],
                                "fk_category_id": refTable[ref]["fk_category_id"]
                            };

                            axios.patch('/api/references/' + previousRefId, editPreviousRef)
                                .then(function (resp) {
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in MainList.vue !");
                                });
                            axios.patch('/api/references/' + id, editCurrentRef)
                                .then(response => { 
                                    this.referencesSuccess(response, "Modification effectuée !");
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in MainList.vue !");
                                });
                        }
                    }
                }
            },
        //MOVE REF DOWN
            moveRefDown(id) {
                // Search for the parent category
                var ParentCategory;
                for (let ref = 0; ref < this.references.length; ref++) {
                    if (this.references[ref]["id"] === id) {
                        ParentCategory = this.references[ref]["fk_category_id"];
                        break;
                    }
                }
                // Search for all others references belonging to this parent
                var refTable = [];
                for (let ref = 0; ref < this.references.length; ref++) {
                    if (this.references[ref]["fk_category_id"] == ParentCategory) {
                        refTable.push(this.references[ref]);
                    }
                }

                // Now to make it work

                for (let ref = 0; ref < refTable.length; ref++) {
                    if (refTable[ref]["id"] === id) {
                        // If next exists
                        if (refTable[ref+1]) {
                            var nextRefId = refTable[ref+1]["id"]

                            var editCurrentRef = {
                                "icon": refTable[ref]["icon"],
                                "weight": refTable[ref+1]["weight"],
                                "fk_category_id": refTable[ref]["fk_category_id"]
                            };
                            var editNextRef = {
                                "icon": refTable[ref+1]["icon"],
                                "weight": refTable[ref]["weight"],
                                "fk_category_id": refTable[ref+1]["fk_category_id"]
                            };
                            
                            axios.patch('/api/references/' + id, editCurrentRef)
                                .then(response => { 
                                    this.referencesSuccess(response, "Modification effectuée !");
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in MainList.vue !");
                                });
                            axios.patch('/api/references/' + nextRefId, editNextRef)
                                .then(function (resp) {
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in MainList.vue !");
                                });
                        }
                    }
                }
            },
        // REFERENCE SUCCESS
            referencesSuccess(response, msg) {
                this.snackbar = true;
                this.snackText = msg;
                this.references = [];
                this.references = referencesMethods.readReferences();
            },
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
                    this.dialogText = 'Veuillez confirmer la suppression de la catégorie '+idName,
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
                    this.dialogText = 'Veuillez confirmer la suppression de la référence '+idName,
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
                    this.dialogText = 'Veuillez confirmer la suppression du point '+idName,
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
                    for (let i = 0; i < this.pointsContents.length; i++) {
                        if (this.pointsContents[i]["fk_point_id"] == id) {
                            pointsMethods.destroyPointName(this.pointsContents[i]["id"]);
                        }
                    }
                    //reload references list
                    //mimics a reload
                    this.points = [];
                    this.points = pointsMethods.readPoints();
                    this.pointsContents = [];
                    this.pointsContents = pointsMethods.readPointsPopupContent();
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
    .borderCategories:before {
        content:'';
        position:absolute;
        width:100%;
        height:3px;
        background:linear-gradient(to left, rgba(0, 0, 0, 0), #388E3C, rgba(0, 0, 0, 0));
        top:0px;
        left:0;
    }
    .borderReferences{
        content:'';
        position:absolute;
        width:100%;
        height:3px;
        background:linear-gradient(to left, rgba(0, 0, 0, 0), #A5D6A7, rgba(0, 0, 0, 0));
        top:0px;
        left:0;
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
        border-bottom: 1px !important;
        border-bottom-color: rgb(87, 87, 87) !important;
        border-bottom-style:solid !important;
    }
    .v-btn--small{
        min-width: 25px !important;
    }
    .v-menu__content{
        background-color: white !important;
    }

    /* .v-snack--bottom{
        bottom: 50px;
    } */
</style>