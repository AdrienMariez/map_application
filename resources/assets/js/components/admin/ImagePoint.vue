<template>
    <v-flex xs12 class="my-5">
        <!-- Image list -->
            <v-expansion-panel>
                <v-expansion-panel-content
                    color="green lighten-3"
                    class="green lighten-3 highlightHeader">
                    <div slot="header">Banque d'images</div>
                        <v-card>
                            <!-- button show upload -->
                                <v-btn
                                    v-if="add == false"
                                    color="success"
                                    @click="add = true">
                                    ajouter Image
                                </v-btn>
                            <!-- upload tool -->
                                <div v-if="add == true" class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Upload pic input -->
                                                <div class="col-md-6">
                                                    <input
                                                        type="file"
                                                        accept="image/*"
                                                        v-on:change="onImageChange"
                                                        class="form-control">
                                                </div>
                                            <!-- Uploaded pic preview -->
                                                <div
                                                    class="col-md-2" v-if="imageUpload">
                                                    <img
                                                        :src="imageUpload"
                                                        class="img-responsive"
                                                        height="70"
                                                        width="90">
                                                </div>
                                            <!-- Upload button -->
                                                <div
                                                    class="col-md-2"
                                                    v-if="imageUpload">
                                                    <v-btn
                                                        color="success"
                                                        @click="uploadImage">
                                                        Upload Image
                                                        </v-btn>
                                                </div>
                                            <!-- Cancel button -->
                                                <div
                                                    class="col-md-2">
                                                    <v-btn
                                                        color="error"
                                                        @click="add = false">
                                                        Annuler
                                                    </v-btn>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- tutorial -->
                                <v-divider></v-divider>
                                <div>
                                    <v-tooltip
                                        top>
                                        <v-icon
                                            color="purple lighten-1"
                                            class="iconTooltip"
                                            slot="activator">
                                            help
                                        </v-icon>
                                        <ul>
                                            <li>Choisir une image en cliquant dessus.</li>
                                            <li>Cliquer sur l'icône suppression supprimera l'image du site si elle n'est plus utilisée nulle part.</li>
                                            <li>Une image choisie peut être enlevée du point en cliquant sur l'icône X</li>
                                        </ul>
                                    </v-tooltip>
                                </div>
                            <!-- Pics list -->
                                <v-layout align-center justify-space-around fill-height row wrap>
                                    <v-flex
                                        v-for="(img,i) in images"
                                        :key="i"
                                        class="imgContainer xs3 ma-3">
                                        <v-btn
                                            absolute
                                            dark
                                            fab
                                            center
                                            small
                                            color="error"
                                            v-on:click="deleteImage(img.id)">
                                            <v-icon>
                                                delete_forever
                                            </v-icon>
                                        </v-btn>
                                        <img
                                            xs3
                                            color="transparent"
                                            :src="img.image_path"
                                            @click="selectImage(img.id,$event.target)">
                                    </v-flex>
                                </v-layout>
                        </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        <!-- Selected image -->
            <div v-if="image.length !== 0" class="card card-default">
                <div class="card-header">
                    Image sélectionnée :
                </div>
                <div class="card-body">
                    <div class="row imgContainerPreview xs3 ma-3">
                        <v-btn
                            absolute
                            dark
                            fab
                            center
                            small
                            color="error"
                            v-on:click="$emit('clearImage')">
                            <v-icon>
                                clear
                            </v-icon>
                        </v-btn>
                        <img
                            xs3
                            v-bind:src="image"
                            alt="aperçu de l'image">
                    </div>
                </div>
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
                Fermer
            </v-btn>
        </v-snackbar>
    <!-- Alert in case of imminent destroy -->
        <v-layout row justify-center>
            <v-dialog v-model="dialog" persistent>
                <v-card>
                    <v-card-text class="headline text-xs-center">
                        Supprimer l'image ?
                    </v-card-text>
                    <v-card-text class="text-xs-center">
                        <v-layout align-center justify-center column fill-height>
                        <div class="row imgContainerDialog xs3 ma-3 text-xs-center">
                            <img
                                xs3
                                v-bind:src="dialogImage"
                                alt="aperçu de l'image en cours de suppression">
                        </div>
                        </v-layout>
                        Cette suppression sera irreversible à partir de l'acceptation de cette boîte de dialogue.
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
                                destroyImage(dialogId),
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
    </v-flex>
</template>

<script>
    import imagesMethods from './../../services/images.js'
    import pointsMethods from './../../services/points.js'

    export default {
        props: ['image'],
        data () {
            return {
                images: [],
                points: [],
                pointsWhereImageUsed: [],
                add: false,
                selectedImgHtmlDisplay: "",
                selectedImageId: null,
                imageInitial_fk : "",
                imageUpload: "",
                
                snackbarLoading: false,
                snackText: "",
                snackbar: false,
                dialog: false,
                dialogId: null,
                dialogImage: '',
            }
        },
        watch: {
        },
        methods: {
            selectImage(img, selectedImgHtmlDisplay) {
                if (this.selectedImgHtmlDisplay instanceof Element) {
                    this.selectedImgHtmlDisplay.removeAttribute("class", "selectedImg");
                }
                selectedImgHtmlDisplay.setAttribute("class", "selectedImg");

                this.selectedImgHtmlDisplay = selectedImgHtmlDisplay;
                
                this.selectedImageId = img;
                
                this.$emit('imageSelected', img);
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
                this.add = false;
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = "Upload effectué !"
                this.images = imagesMethods.readImages();
                this.$emit('imageListReload');
                this.imageUpload = "";
            },
            failedUpload(error) {
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
            deleteImage(id) {
                var verifImageUsed = false;
                for (let point = 0; point < this.points.length; point++) {
                    if (this.points[point]["fk_image_id"] === id) {
                        verifImageUsed = true;
                    }
                }
                if (verifImageUsed === false) {
                    var img;
                    for (let image = 0; image < this.images.length; image++) {
                        if (this.images[image]["id"] === id) {
                            img = this.images[image]["image_path"]
                        }
                    }
                    this.dialogImage = img;
                    this.dialogId = id;
                    this.dialog = true;
                    // this.destroyImage(id);
                }
                else{
                    this.snackbar = true;
                    this.snackText = "Suppression impossible : le fichier est utilisé autre part sur le site."
                    this.snackbarLoading = false;
                }
            },
            destroyImage(id) {
                if (this.selectedImageId === id) {
                    this.$emit('clearImage');
                }
                this.snackbarLoading = true;
                axios.delete(`api/images/${id}`)
                    .then(response => { 
                        this.successDestroy(response);
                    })
                    .catch(error => {
                        this.failedDestroy(error);
                    });
            },
            successDestroy(response) {
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = "Suppression effectuée !"
                this.images = imagesMethods.readImages();
                this.$emit('imageListReload');
                this.imageUpload = "";
            },
            failedDestroy(error) {
                console.log(error);
                
                this.snackbar = true;
                this.snackText = "Erreur lors de la suppression du fichier !"
                this.snackbarLoading = false;
            },

            //API CALLS
                methodsApiCalls() {
                    this.images = imagesMethods.readImages();
                    this.points = pointsMethods.readPoints();
                },
        },
        created() {
            this.methodsApiCalls();
        }
    }
</script>

<style scoped>
    .highlightHeader:hover{
        background-color: #81C784 !important;
    }
    .imgContainer{
        max-width:100px !important;
        min-width:50px !important;
        box-shadow: 0px 5px 10px 2px #afafaf;
        cursor: pointer;
    }
    .imgContainerPreview{
        max-width: 90vw !important;
        width:250px !important;
        min-width:75px !important;
        box-shadow: 0px 5px 10px 2px #afafaf;
    }
    .imgContainerDialog{
        width:175px !important;
        box-shadow: 0px 5px 5px 2px #afafaf;
    }
    .imgContainer > img, .imgContainerPreview > img{
        width:100% !important;
        height:100% !important;
    }
    .selectedImg {
        padding: 20px;
        background-color: rgb(82, 196, 82);
    }
</style>