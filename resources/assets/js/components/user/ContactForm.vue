<template>
    <v-layout row justify-left>
        <v-dialog v-model="dialog" persistent max-width="500px" transition="dialog-bottom-transition">
            <v-btn
                slot="activator"
                @click="validStart"
                absolute
                dark
                center
                color="green lighten-1">
                <div class="linkColor">{{ $t("message.contact") }}</div>
            </v-btn>
            <v-card>
                <v-card-title>
                    <v-layout wrap justify-space-between>
                        <v-flex xs6 align-left>
                            <span class="headline text-xs-left">{{ $t("message.contact_us") }}</span>
                        </v-flex>
                        <v-flex xs2 align-right>
                            <v-list-tile
                                @click.native="dialog = false"  
                                @click="clear"
                                class="text-xs-right"
                                >
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
                                    <span>{{ $t("message.contact_desc") }}Envoyez nous vos impressions ou vous questions !</span>
                                </v-flex>
                                <v-flex xs12>
                                    <small>{{ $t("message.contact_fr_or_en_only") }}</small>
                                </v-flex>
                                <v-flex xs12>
                                <!-- NAME -->
                                    <div>{{$t("message.contact_name_label")}}</div>
                                    <v-text-field
                                        v-model="name"
                                        :rules="nameRules"
                                        :hint="$t('message.contact_name_hint')"
                                        required
                                        solo
                                        :counter="50"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                <!-- TITLE -->
                                    <div>{{$t("message.contact_title_label")}}</div>
                                    <v-text-field
                                        v-model="title"
                                        :rules="titleRules"
                                        :hint="$t('message.contact_title_hint')"
                                        required
                                        solo
                                        :counter="60"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                <!-- EMAIL -->
                                    <div>{{$t("message.contact_email_label")}}</div>
                                    <v-text-field
                                        v-model="email"
                                        :rules="emailRules"
                                        :hint="$t('message.contact_email_hint')"
                                        required
                                        solo
                                        :counter="40"
                                    ></v-text-field>
                                    <v-icon
                                        @click="legal = !legal">
                                        help
                                    </v-icon>
                                    <div v-if="legal" class="elevation-5 my-3 mx-3 py-3 px-3">
                                        <div>{{$t("message.contact_RGPD_hint_1")}}</div>
                                        <div>{{$t("message.contact_RGPD_hint_2")}}</div>
                                    </div>
                                <!-- TEXT -->
                                    <div>{{$t("message.contact_text_label")}}</div>
                                    <v-textarea
                                        v-model="text"
                                        :rules="textRules"
                                        outline
                                        :hint="$t('message.contact_text_hint')"
                                        solo
                                        :counter="1000"
                                    ></v-textarea>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <small>{{ $t("message.contact_required_fields") }}</small>
                    </v-card-text>
                    <v-card-actions>
                        <v-layout row wrap justify-space-between>
                            <!-- <v-flex xs2> -->
                                <v-list-tile @click="clear">
                                    <v-list-tile-action class="cursorAction">
                                        <v-icon>close</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile>
                            <!-- </v-flex>
                            <v-flex> -->
                                <v-btn
                                    v-if="!valid"
                                    :disabled="!valid"
                                    color="grey lighten-1">
                                    <v-icon>send</v-icon>
                                </v-btn>
                                <v-btn
                                    v-if="valid"
                                    :disabled="!valid"
                                    @click="submit"
                                    large
                                    color="success">
                                    <v-icon>send</v-icon>
                                </v-btn>
                                <!-- <v-list-tile
                                    :disabled="!valid"
                                    @click="submit">
                                    <v-list-tile-action class="cursorAction">
                                        <v-icon>send</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile> -->
                            <!-- </v-flex> -->
                        </v-layout>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        data () {
            return {
                dialog: false,
                valid: false,
                errorMessage: '',

                name: '',
                nameRules: [
                    v => !!v || this.$t('message.contact_nameRules_required'),
                    v => (v && v.length <= 100) || this.$t('message.contact_too_long')
                ],
                title: '',
                titleRules: [
                    v => !!v || this.$t('message.contact_titleRules_required'),
                    v => (v && v.length <= 100) || this.$t('message.contact_too_long')
                ],
                email: '',
                emailRules: [
                    // v => /.+@.+/.test(v) || 'E-mail must be valid'
                ],
                text: '',
                textRules: [
                    v => !!v || this.$t('message.contact_textRules_required'),
                    v => (v && v.length <= 1000) || this.$t('message.contact_too_long')
                ],

                legal: false,

                contact: {
                    name: "",
                    title: "",
                    email: "",
                    message: ""
                },
            }
        },
        watch: {
            // watchers name, title, email, text to test validation
            name(val, oldVal){
                // Verification of presence of variables (prevents errors when closing the contact form as the variables are reset)
                if (this.name && this.title && this.email && this.text) {
                    this.validation();
                }
            },
            title(val, oldVal){
                if (this.name && this.title && this.email && this.text) {
                    this.validation();
                }
            },
            email(val, oldVal){
                if (this.name && this.title && this.email && this.text) {
                    this.validation();
                }
            },
            text(val, oldVal){
                if (this.name && this.title && this.email && this.text) {
                    this.validation();
                }
            },
        },
        methods: {
            validStart () {
                // Forces valid false when showing the form
                this.valid = false;
            },
            validation () {
                // Disable the form validation button when the values are not correct
                var valid;
                var error = "";

                if (this.name.length == 0) {
                    error += "name = 0, "
                }
                if (this.name.length > 50) {
                    error += "name >= 50, "
                }
                if (this.title.length == 0) {
                    error += "title = 0, "
                }
                if (this.title.length > 60) {
                    error += "title >= 60, "
                }
                if (this.email.length > 40) {
                    error += "email >= 40, "
                }
                if (this.text.length == 0) {
                    error += "text = 0, "
                }
                if (this.text.length > 1000) {
                    error += "text >= 1000"
                }

                if (error.length > 0) {
                    valid = false;
                }
                else{
                    valid = true;
                }
                this.valid = valid;
            },
            submit () {
                if (this.$refs.form.validate()) {
                // Native form submission is not yet supported
                    var mail =this.$t('message.contact_optionnal_mail');
                    if (this.email) {
                        mail = this.email;
                    }
                    this.contact.name = this.name;
                    this.contact.title = this.title;
                    this.contact.email = mail;
                    this.contact.message = this.text;

                    var newContact = this.contact;

                    axios.post('/api/contact', newContact)
                        .then(
                            resp =>
                                Promise.all([
                                resp,
                                this.clear (),
                                ])   
                            )
                        .catch(error => {
                            console.log(error.response.data);
                        
                            alert("Un problème est survenu lors de la création. Error located in ContactForm.vue !");
                        });

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
        right: 20px;
        bottom: 0px;
        z-index: 30;
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