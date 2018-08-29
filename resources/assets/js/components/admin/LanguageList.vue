<template>
    <div>
        <!-- Existing languages list -->
        <v-list
            two-line 
            class="mt-5">
            <v-subheader>
                Langues implémentées (cliquer pour mettre à jour):
            </v-subheader>
            <!-- <v-divider></v-divider> -->
            <template v-for="(language,i) in languages">
                <v-list-tile
                    :key="i"
                    avatar
                    @click="dummy()"
                    class="hoveredItem">
                    <v-list-tile-content @click="updateLanguageMode(language.id)">
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
                        @click="deleteLanguage(language.id)">
                        <v-icon>delete</v-icon>
                    </v-btn>
                </v-list-tile>
            </template>
        </v-list>
        <v-divider></v-divider>
        <!-- Creation button -->
        <div
            v-if="selectedId !== null">
            <v-btn
                class="mt-5"
                color="success"
                @click="createLanguageMode()">
                <v-icon>add</v-icon>
                Passer en mode création
            </v-btn>
            <v-divider></v-divider>
        </div>
        <!-- Create/edit form -->
        <v-form
            v-if="editForm = true"
            ref="form"
            v-model="valid"
            lazy-validation
            class="mt-5">
            <v-subheader
                v-if="selectedId !== null">
                Edition de {{editedName}} ({{editedCode}}):
            </v-subheader>
            <v-subheader
                v-else>
                Création :
            </v-subheader>
            <!-- <v-divider></v-divider> -->
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 class="my-5">
                            <div>Nom de la langue : </div>
                            <v-text-field
                                v-model=selectedName
                                value= selectedName
                                solo
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
                                solo
                                class="mb-2"
                                hint="Utilisez les codes de la norme ISO 639-1 : https://fr.wikipedia.org/wiki/Liste_des_codes_ISO_639-1"
                                persistent-hint
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-layout align-center column justify-center>
                    <v-flex>
                        <v-btn
                            v-if="selectedId !== null && validButton"
                            :disabled="!validButton"
                            @click="submitEdit"
                            color="success">
                            <v-icon>add</v-icon> Modifier
                        </v-btn>
                        <v-btn
                            v-if="selectedId !== null && !validButton"
                            :disabled="!validButton"
                            @click="submitEdit"
                            color="grey lighten-1">
                            <v-icon>add</v-icon> Modifier
                        </v-btn>
                        <v-btn
                            v-if="selectedId === null && validButton"
                            :disabled="!validButton"
                            @click="submitCreate"
                            color="success">
                            <v-icon>add</v-icon> Créer
                        </v-btn>
                        <v-btn
                            v-if="selectedId === null && !validButton"
                            :disabled="!validButton"
                            @click="submitCreate"
                            color="grey lighten-1">
                            <v-icon>add</v-icon> Créer
                        </v-btn>
                    </v-flex>
                    <v-flex>
                        <div class="validationFailure">
                            {{validationFailure}}
                        </div>
                    </v-flex>
                </v-layout>
            </v-card-actions>
        </v-form>

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
        <!-- Alert in case of imminent destroy -->
            <v-layout row justify-center>
                <v-dialog v-model="dialog" persistent max-width="290">
                    <v-card>
                        <v-card-title class="headline">
                            Supprimer la langue ?
                        </v-card-title>
                        <v-card-text>
                            Cette suppression sera irreversible à partir de l'acceptation de cette boîte de dialogue.
                        </v-card-text>
                        <v-card-text>
                            ATTENTION ! La suppression de la langue entraînera la destruction de toutes les données associées !
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="green darken-1"
                                flat
                                @click.native="
                                    dialog = false,
                                    dialogId = null"
                                >
                                <v-icon>keyboard_backspace</v-icon>
                                Retour
                            </v-btn>
                            <v-btn
                                color="error"
                                flat
                                @click.native="
                                    destroyLanguage(dialogId),
                                    dialog = false,
                                    dialogId = null"
                                >
                                <v-icon>delete</v-icon>
                                Supprimer
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-layout>
    </div>
</template>

<script>
    import languagesMethods from './../../services/languages.js'
    import pointsMethods from './../../services/points.js'
    import referencesMethods from './../../services/references.js'
    import categoriesMethods from './../../services/categories.js'
        export default {
        data () {
            return {
                languages: [],
                
                categories: [],
                references: [],
                points: [],

                categoriesNames: [],
                referenceNames: [],
                pointsContents: [],
                
                editForm: false,
                selectedId: null,
                selectedName: "",
                selectedCode: "",

                editedName: "",
                editedCode: "",

                valid: false,
                validButton: false,
                validationFailure: "",

                snackbarLoading: false,
                snackText: "",
                snackbar: false,
                dialog: false,
                dialogId: null,

                language: {
                    id: null,
                    name: "",
                    code: "",
                },
            }
        },
        watch: {
            selectedName(){
                this.validation();
            },
            selectedCode(){
                this.validation();
            },
        },
        methods: {
            dummy() {},
            createLanguageMode() {
                console.log("createLanguage");
                this.editForm = true;
                this.selectedId = null;
                this.selectedName = "";
                this.selectedCode = "";
            },
            updateLanguageMode(id) {
                // var languages = JSON.parse(JSON.stringify(this.languages));
                this.selectedId = id;
                for (let lang = 0; lang < this.languages.length; lang++) {
                    if (this.languages[lang]["id"] === id) {
                        this.selectedName = this.languages[lang]["name"];
                        this.editedName = this.languages[lang]["name"];
                        this.selectedCode = this.languages[lang]["code"];
                        this.editedCode = this.languages[lang]["code"];
                    }
                }
                this.editForm = true;
            },

            validation() {
                var valid = true;
                var validationFailure = "Impossible de créer la langue pour les raisons suivantes :  ";
                // selectedName
                    if (this.selectedName.length == 0) {
                        valid = false;
                        validationFailure += " Le nom est manquant.";
                    }
                    if (this.selectedName.length > 30) {
                        valid = false;
                        validationFailure += " Le nom est invalide.";
                    }
                // END selectedName
                // selectedCode
                    if (this.selectedCode.length == 0) {
                        valid = false;
                        validationFailure += " Le code est manquant.";
                    }
                    if (this.selectedCode.length > 2) {
                        valid = false;
                        validationFailure += " Le code est invalide.";
                    }
                // END selectedCode
                if (valid == true) {
                    this.valid = true;
                    this.validButton = true;
                    this.validationFailure = "";
                }
                else{
                    this.valid = false;
                    this.validButton = false;
                    this.validationFailure = validationFailure;
                }
            },

            submitCreate() {
                this.language.name = this.selectedName;
                this.language.code = this.selectedCode;
                var newLanguage = this.language;

                this.snackbarLoading = true;

                axios.post('/api/languages', newLanguage)
                    .then(response => { 
                        this.success(response, "Création effectuée avec succès.");
                    })
                    .catch(error => {
                        this.failed(error, "Erreur lors de la création de la langue !");
                    });

                // Create all data
                    var language = this.selectedCode;
                // For each category, create category name
                    for (let cat = 0; cat < this.categories.length; cat++) {
                        var id = this.categories[cat]["id"];

                        var newCatName = {
                            "fk_category_id": id,
                            "fk_language_code": language,
                            "text": "[missing]",
                        };

                        axios.post('/api/categoriesnames', newCatName)
                        .then(function (resp) {
                            console.log("cat create complete");
                        })
                        .catch(function (error) {
                            console.log(error.response.data);
                            
                            alert("Un problème est survenu lors de la création. Error located in LanguageList.vue !");
                        });
                    }
                    this.categoriesNames = [];
                    this.categoriesNames = categoriesMethods.readCategoriesNames();
                // For each reference, create reference name
                    for (let ref = 0; ref < this.references.length; ref++) {
                        var id = this.references[ref]["id"];

                        var newRefName = {
                            "fk_reference_id": id,
                            "fk_language_code": language,
                            "text": "[missing]",
                        };

                        axios.post('/api/referencesnames', newRefName)
                        .then(function (resp) {
                            console.log("ref create complete");
                        })
                        .catch(function (error) {
                            console.log(error.response.data);
                            
                            alert("Un problème est survenu lors de la création. Error located in LanguageList.vue !");
                        });
                    }
                    this.referenceNames = [];
                    this.referenceNames = referencesMethods.readReferenceNames();
                // For each point, create point name
                    for (let poi = 0; poi < this.points.length; poi++) {
                        var id = this.points[poi]["id"];
                        var newPoiName = {
                            "fk_point_id": id,
                            "fk_language_code": language,
                            "title": "[missing]",
                            "description": "[missing]",
                            "linkalias": "[missing]",
                        };

                        axios.post('/api/pointsnames', newPoiName)
                        .then(function (resp) {
                            console.log("point create ok");
                        })
                        .catch(function (error) {
                            console.log(error.response.data);
                            
                            alert("Un problème est survenu lors de la création. Error located in LanguageList.vue !");
                        });
                    }
                    this.pointsContents = [];
                    this.pointsContents = pointsMethods.readPointsPopupContent();
            },
            submitEdit() {
                var id = this.selectedId;

                this.language.id = id;
                this.language.name = this.selectedName;
                this.language.code = this.selectedCode;
                var newLanguage = this.language;

                this.snackbarLoading = true;
                axios.patch('/api/languages/' + id, newLanguage)
                    .then(response => { 
                        this.success(response, "Modification effectuée avec succès.");
                    })
                    .catch(error => {
                        this.failed(error, "Erreur lors de la modification de la langue !");
                    });


                // Edit all data
                    var language = ""
                    for (let lang = 0; lang < this.languages.length; lang++) {
                        if (this.languages[lang]["id"] == id) {
                            language = this.languages[lang]["code"];
                        }
                    }
                // Edit categories names
                    for (let cat = 0; cat < this.categoriesNames.length; cat++) {
                        if (this.categoriesNames[cat]["fk_language_code"] == language) {
                            var id = this.categoriesNames[cat]["id"];

                            var newCatName = {
                                "fk_category_id": this.categoriesNames[cat]["fk_category_id"],
                                "fk_language_code": this.selectedCode,
                                "text": this.categoriesNames[cat]["text"],
                            };

                            axios.patch('/api/categoriesnames/' + id, newCatName)
                                .then(function (resp) {
                                    console.log("cat edit complete");
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in LanguageList.vue !");
                                });
                        }
                    }
                    this.categoriesNames = [];
                    this.categoriesNames = categoriesMethods.readCategoriesNames();
                // Edit references names
                    for (let ref = 0; ref < this.referenceNames.length; ref++) {
                        if (this.referenceNames[ref]["fk_language_code"] == language) {
                            var id = this.referenceNames[ref]["id"];

                            var newRefName = {
                                "fk_reference_id": this.referenceNames[ref]["fk_reference_id"],
                                "fk_language_code": this.selectedCode,
                                "text": this.referenceNames[ref]["text"],
                            };

                            axios.patch('/api/referencesnames/' + id, newRefName)
                                .then(function (resp) {
                                    console.log("ref edit complete");
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in LanguageList.vue !");
                                });
                        }
                    }
                    this.referenceNames = [];
                    this.referenceNames = referencesMethods.readReferenceNames();
                // Edit points names
                    for (let poi = 0; poi < this.pointsContents.length; poi++) {
                        if (this.pointsContents[poi]["fk_language_code"] == language) {
                            var id = this.pointsContents[poi]["id"];

                            var newPoiName = {
                                "fk_point_id": this.pointsContents[poi]["fk_point_id"],
                                "fk_language_code": this.selectedCode,
                                "title": this.pointsContents[poi]["title"],
                                "description": this.pointsContents[poi]["description"],
                                "linkalias": this.pointsContents[poi]["linkalias"],
                            };

                            axios.patch('/api/pointsnames/' + id, newPoiName)
                                .then(function (resp) {
                                    console.log("point edit complete");
                                })
                                .catch(function (error) {
                                    console.log(error.response.data);
                                    
                                    alert("Un problème est survenu lors de la mise à jour. Error located in LanguageList.vue !");
                                });
                        }
                    }
                    this.pointsContents = [];
                    this.pointsContents = pointsMethods.readPointsPopupContent();
            },

            deleteLanguage(id) {
                this.dialogId = id;
                this.dialog = true;
            },
            destroyLanguage(id) {
                this.snackbarLoading = true;
                axios.delete(`api/languages/${id}`)
                    .then(response => { 
                        this.success(response, "Suppression effectuée !");
                    })
                    .catch(error => {
                        this.failed(error, "Erreur lors de la suppression de la langue !");
                    });

                // Destroy all data
                    var language = ""
                    for (let lang = 0; lang < this.languages.length; lang++) {
                        if (this.languages[lang]["id"] == id) {
                            language = this.languages[lang]["code"];
                        }
                    }
                // Destroy categories names
                    for (let cat = 0; cat < this.categoriesNames.length; cat++) {
                        if (this.categoriesNames[cat]["fk_language_code"] == language) {
                            categoriesMethods.destroyCategoryName(this.categoriesNames[cat]["id"]);
                        }
                    }
                    this.categoriesNames = [];
                    this.categoriesNames = categoriesMethods.readCategoriesNames();
                // Destroy references names
                    for (let ref = 0; ref < this.referenceNames.length; ref++) {
                        if (this.referenceNames[ref]["fk_language_code"] == language) {
                            referencesMethods.destroyReferenceName(this.referenceNames[ref]["id"]);
                        }
                    }
                    this.referenceNames = [];
                    this.referenceNames = referencesMethods.readReferenceNames();
                // Destroy points names
                    for (let poi = 0; poi < this.pointsContents.length; poi++) {
                        if (this.pointsContents[poi]["fk_language_code"] == language) {
                            pointsMethods.destroyPointName(this.pointsContents[poi]["id"]);
                        }
                    }
                    this.pointsContents = [];
                    this.pointsContents = pointsMethods.readPointsPopupContent();
            },

            success(response, msg) {
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = msg;
                this.reloadLanguages();
            },
            failed(error) {
                console.log(error);
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = msg;
            },
            
            reloadLanguages() {
                this.languages = [];
                this.languages = languagesMethods.readLanguages();
            },
            //API CALLS
                methodsApiCalls() {
                    this.languages = languagesMethods.readLanguages();

                    //needed for create action
                    this.categories = categoriesMethods.readCategories();
                    this.references = referencesMethods.readReferences();
                    this.points = pointsMethods.readPoints();

                    //needed for edit/delete action
                    this.categoriesNames = categoriesMethods.readCategoriesNames();
                    this.referenceNames = referencesMethods.readReferenceNames();
                    this.pointsContents = pointsMethods.readPointsPopupContent();
                },
        },
        created() {
            this.methodsApiCalls();
            this.validation()
        }
    }
</script>

<style scoped>
    .hoveredItem:hover{
        background-color: rgb(233, 233, 233) !important;
    }
</style>