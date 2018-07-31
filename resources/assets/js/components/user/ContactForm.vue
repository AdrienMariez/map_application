<template>
    <v-layout row justify-left>
        <v-dialog v-model="dialog" persistent max-width="500px" transition="dialog-bottom-transition">
            <v-btn
                slot="activator"
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
                                    <v-text-field
                                        v-model="name"
                                        :rules="nameRules"
                                        :label="$t('message.contact_name_label')"
                                        :hint="$t('message.contact_name_hint')"
                                        required
                                        :counter="100"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                        v-model="title"
                                        :rules="titleRules"
                                        :label="$t('message.contact_title_label')"
                                        :hint="$t('message.contact_title_hint')"
                                        required
                                        :counter="100"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                        v-model="email"
                                        :rules="emailRules"
                                        :label="$t('message.contact_email_label')"
                                        :hint="$t('message.contact_email_hint')"
                                        required
                                        :counter="100"
                                    ></v-text-field>
                                    <v-textarea
                                        v-model="text"
                                        :rules="textRules"
                                        outline
                                        :label="$t('message.contact_text_label')"
                                        :hint="$t('message.contact_text_hint')"
                                        :counter="1000"
                                    ></v-textarea>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <small>{{ $t("message.contact_required_fields") }}</small>
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
        data () {
            return {
                dialog: false,
                valid: true,
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
            }
        },
        methods: {
            submit () {
                if (this.$refs.form.validate()) {
                // Native form submission is not yet supported
                    optionnalMail =this.$t('message.contact_optionnal_mail');
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

                // if (this.$refs.form.validate()) {
                // // Native form submission is not yet supported
                //     optionnalMail ='Courriel non renseigné';
                //     if (this.email.length > 0) {
                //         optionnalMail = this.email;
                //     }
                //     axios.post('/api/contactform', {
                //         name: this.name,
                //         title: this.title,
                //         email: optionnalMail,
                //         text: this.text
                //     })
                //     this.dialog = false;
                // }
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