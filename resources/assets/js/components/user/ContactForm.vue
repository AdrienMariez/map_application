<template>

    <v-layout row justify-left>
        <v-dialog v-model="dialog" persistent max-width="500px" transition="dialog-bottom-transition">
            <v-btn
                slot="activator"
                absolute
                dark
                center
                color="green lighten-1">
                <div class="linkColor">Contact</div>
            </v-btn>
            <v-card>
                <v-card-title>
                    <v-layout row wrap justify-space-between>
                        <v-flex xs6 align-left>
                            <span class="headline text-xs-left">Contactez-nous</span>
                        </v-flex>
                        <v-flex xs2 align-right>
                            <v-list-tile @click.native="dialog = false"  class="text-xs-right">
                                <v-list-tile-action class="cursorAction">
                                    <v-icon>close</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-flex>
                    </v-layout>
                </v-card-title>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <span>Envoyez nous vos impressions ou vous questions !</span>
                                </v-flex>
                                <v-flex xs12>
                                    <small>(Français ou Anglais uniquement)</small>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                        v-model="name"
                                        :rules="nameRules"
                                        label="Votre nom *"
                                        hint="La saisie de votre nom est obligatoire"
                                        required
                                        :counter="100"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                        v-model="title"
                                        :rules="titleRules"
                                        label="Titre *"
                                        hint="La saisie du titre du message est obligatoire"
                                        required
                                        :counter="100"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                        v-model="email"
                                        :rules="emailRules"
                                        label="Votre courriel"
                                        hint="Ne remplissez ce champ que si vous souhaitez être recontactés."
                                        required
                                        :counter="100"
                                    ></v-text-field>
                                    <v-textarea
                                        v-model="text"
                                        :rules="textRules"
                                        outline
                                        label="Texte *"
                                        hint="La saisie du contenu du message est obligatoire"
                                        :counter="1000"
                                    ></v-textarea>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <small>* indique un champ obligatoire</small>
                    </v-card-text>
                    <v-card-actions>
                        <v-layout row wrap justify-space-between>
                            <v-flex xs2 align-left>
                                <v-list-tile @click="clear">
                                    <v-list-tile-action class="cursorAction">
                                        <v-icon>close</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-flex>
                            <v-flex xs2 align-right>
                                <v-list-tile
                                    :disabled="!valid"
                                    @click="submit">
                                    <v-list-tile-action class="cursorAction">
                                        <v-icon>send</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-flex>
                        </v-layout>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        // props: ['value'],
        data () {
            return {
                dialog: false,
                valid: true,
                name: '',
                nameRules: [
                    v => !!v || 'La saisie de votre nom est obligatoire',
                    v => (v && v.length <= 100) || 'Trop long'
                ],
                title: '',
                titleRules: [
                    v => !!v || 'La saisie du titre du message est obligatoire',
                    v => (v && v.length <= 100) || 'Trop long'
                ],
                email: '',
                emailRules: [
                    // v => /.+@.+/.test(v) || 'E-mail must be valid'
                ],
                text: '',
                textRules: [
                    v => !!v || 'La saisie du contenu du message est obligatoire',
                    v => (v && v.length <= 1000) || 'Trop long'
                ],
            }
        },
        methods: {
            submit () {
                if (this.$refs.form.validate()) {
                // Native form submission is not yet supported
                    optionnalMail ='Courriel non renseigné';
                    if (this.email.length > 0) {
                        optionnalMail = this.email;
                    }
                    axios.post('/api/contactform', {
                        name: this.name,
                        title: this.title,
                        email: optionnalMail,
                        text: this.text
                    })
                    this.dialog = false;
                }
            },
            clear () {
                this.$refs.form.reset()
                this.dialog = false;
            }
        }
    }
</script>

<style scoped>
    .buttonContact{
        height: 45px;
        width: 100px;
        position: absolute;
        right: 0;
        bottom: 0px;
        z-index: 1;
    }
    .buttonContact > button{
        right: 5px;
    }
    .linkColor{
        color: rgb(245, 255, 153);
    }
    .logoContainerMini{
        height: 100%;
    }
    .logoContainerMini > img{
        width: 48px;
        height: 48px;
    }
    .cursorAction{
        cursor: pointer;
    }
    a{
        color: rgb(146, 221, 123) !important;
        text-decoration: inherit;
    }
</style>