<template>
    <div>
        <v-list
            two-line
            v-bind:search="search">
            <v-subheader>
                Contacts :
            </v-subheader>
            <!-- search field -->
            <v-text-field
                :append-icon="search?'close':'search'"
                :append-icon-cb="() => (search = '')"
                @keydown.native="search=''"
                label="Rechercher un nom"
                single-line
                hide-details
                solo
                v-model="search"
            ></v-text-field>
            <v-data-table
                :headers="headers"
                :items="filteredList"
                class="elevation-10 mt-5">
                <template
                    slot="items"
                    slot-scope="props">
                    <td
                        class="hidden-sm-and-down"
                        @click="read(props.item.id, props.item.name, props.item.title, props.item.email, props.item.message, props.item.created_at, props.item.updated_at)">
                        {{ props.item.title }}
                    </td>
                    <td
                        @click="read(props.item.id, props.item.name, props.item.title, props.item.email, props.item.message, props.item.created_at, props.item.updated_at)">
                        {{ props.item.name }}
                    </td>
                    <td
                        @click="read(props.item.id, props.item.name, props.item.title, props.item.email, props.item.message, props.item.created_at, props.item.updated_at)">
                        {{ props.item.created_at }}
                    </td>
                </template>
                <template slot="no-data">
                    <v-alert :value="true" color="error" icon="warning">
                        Aucun message à afficher.
                    </v-alert>
                </template>
            </v-data-table>
            <!-- OBSOLETE list -->
                <!-- <template v-for="(contact,i) in filteredList"> -->
                    <!-- <v-list-tile
                        :key="i"
                        @click="read(contact.id, contact.name, contact.title, contact.email, contact.message, contact.created_at, contact.updated_at)">
                        <v-subheader
                            v-if="contact.title"
                            :key="contact.title"
                            class="subheader">
                            {{ contact.title }}
                        </v-subheader>
                        <v-list-tile-content>
                                    <v-list-tile-title v-html="contact.name"></v-list-tile-title>
                                    <v-list-tile-sub-title v-html="contact.created_at"></v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile> -->
                <!-- </template> -->
            <!-- END OBSOLETE list -->
        </v-list>

        <!-- Show message -->
            <v-layout row justify-center>
                <v-dialog v-model="dialog" persistent>
                    <v-card>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="green darken-1"
                                flat
                                @click.native="
                                    dialog = false,
                                    dialogId = null">
                                    <v-icon>keyboard_backspace</v-icon>
                                Retour
                            </v-btn>
                            <v-btn
                                color="error"
                                flat
                                @click.native="
                                deleteContact(contact.id)">
                                <v-icon>delete</v-icon>
                                Supprimer
                            </v-btn>
                        </v-card-actions>
                        <v-card-title class="headline">
                            {{contact.title}}
                        </v-card-title>
                        <v-card-text>
                            {{contact.dateLong}}
                        </v-card-text>
                        <v-card-text
                            class="hidden-sm-and-down">
                            <v-layout>
                                <v-flex>
                                   <v-icon>person</v-icon> 
                                    {{contact.name}} 
                                </v-flex>
                                <v-flex>
                                    <v-icon>email</v-icon>
                                    {{contact.email}}
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text
                            class="hidden-md-and-up">
                            <v-icon>person</v-icon> 
                            {{contact.name}} 
                        </v-card-text>
                        <v-card-text
                            class="hidden-md-and-up">
                            <v-icon>email</v-icon>
                            {{contact.email}}
                        </v-card-text>
                        <v-card-text>
                            {{contact.message}}
                        </v-card-text>
                        <v-card-actions
                            v-if="contact.message.length > 200">
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
                                deleteContact(contact.id)">
                                <v-icon>delete</v-icon>
                                Supprimer
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-layout>

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
                <v-dialog v-model="removeDialog" persistent max-width="290">
                    <v-card>
                        <v-card-title class="headline">
                            Supprimer le message ?
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
                                    removeDialog = false,
                                    dialogId = null"
                                >
                                <v-icon>keyboard_backspace</v-icon>
                                Retour
                            </v-btn>
                            <v-btn
                                color="error"
                                flat
                                @click.native="
                                    destroyContact(dialogId),
                                    removeDialog = false,
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
    import contactsMethods from './../../services/contacts.js'

    export default {
        data () {
            return {
                contacts: [],
                // contactsLength: null,
                headers: [
                    {
                        text: 'Titre',
                        align: 'left',
                        // sortable: false,
                        value: 'title',
                        class: 'hidden-sm-and-down'
                    },
                    {
                        text: "Nom de l'expediteur",
                        value: 'name'
                    },
                    {
                        text: "Date d'envoi",
                        value: 'created_at'
                    }
                ],

                dialog: false,
                contact: {
                    id: null,
                    name: "",
                    title: "",
                    email: "",
                    message: "",
                    date: "",
                    dateLong: "",
                },

                search: "",

                snackbarLoading: false,
                snackText: "",
                snackbar: false,
                removeDialog: false,
                dialogId: null,
            }
        },
        watch: {
            // contacts(val, oldVal){
            //     this.contactsLength = val.length;
            // },
        },

        computed: {
            filteredList() {
                return this.contacts.filter(contact => {
                    return contact.name.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
        methods: {
            read(id, name, title, email, message, date, dateLong) {
                this.contact.id = id;
                this.contact.name = name;
                this.contact.title = title;
                this.contact.email = email;
                this.contact.message = message;
                this.contact.date = date;
                this.contact.dateLong = dateLong;

                this.dialog = true;
            },

            deleteContact(id) {
                this.dialogId = id;
                this.removeDialog = true;
            },

            destroyContact(id) {
                this.snackbarLoading = true;
                axios.delete(`api/contact/${id}`)
                    .then(response => { 
                        this.success(response, "Suppression effectuée !");
                    })
                    .catch(error => {
                        this.failed(error, "Erreur lors de la suppression du message !");
                    });
            },

            success(response, msg) {
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = msg;
                this.reloadContacts();
                this.dialog = false;

                this.contact.id = null;
                this.contact.name = "";
                this.contact.title = "";
                this.contact.email = "";
                this.contact.message = "";
            },
            failed(error) {
                console.log(error);
                this.snackbarLoading = false;
                this.snackbar = true;
                this.snackText = msg;
            },
            
            reloadContacts() {
                this.contacts = [];
                this.contacts = contactsMethods.readContacts();
            },
            //API CALLS
                methodsApiCalls() {
                    this.contacts = contactsMethods.readContacts();
                },
        },
        created() {
            this.methodsApiCalls();
        }
    }
</script>

<style scoped>
    .subheader{
        overflow: hidden;
        text-overflow: ellipsis;
    }
    td{
        cursor: pointer;
    }
    td:hover{
        background-color: rgb(233, 233, 233) !important;
    }
</style>