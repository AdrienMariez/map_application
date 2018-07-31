
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');

import Vuetify from 'vuetify'

import VueI18n from 'vue-i18n'
Vue.use(VueI18n)

require('./bootstrap');

// import 'leaflet/dist/leaflet.css';
// import 'leaflet.markercluster/dist/MarkerCluster.css';
require('../../../node_modules/leaflet/dist/leaflet.css')
require('../../../node_modules/leaflet.markercluster/dist/MarkerCluster.css')


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from './routes.js';
import AppComponent from './components/AppComponent'

Vue.use(Vuetify)

const messages = {
    en: {
        message: {
            contact:'Contact',
            contact_us:'Contact us',
            contact_desc:'Send us your thoughts or questions !',
            contact_fr_or_en_only:'(French or english only.)',
            contact_name_label:'Your name *',
            contact_name_hint:'Your name is required',
            contact_title_label:'Title *',
            contact_title_hint:'Filling the form title is required',
            contact_email_label:'Your email',
            contact_email_hint:'Fill this field only if you wish to be answered',
            contact_text_label:'Message *',
            contact_text_hint:'Filling the form content is required',
            contact_required_fields:'* indicates a required field',
            contact_nameRules_required:'Your name is required',
            contact_titleRules_required:'Filling the form title is required',
            contact_textRules_required:'Filling the form content is required',
            contact_too_long:'Too long',
            contact_optionnal_mail:'Courriel non renseigné',
        }
    },
    fr: {
        message: {
            contact:'Contact',
            contact_us:'Contactez-nous',
            contact_desc:'Envoyez nous vos impressions ou vous questions !',
            contact_fr_or_en_only:'(Français ou Anglais uniquement)',
            contact_name_label:'Votre nom *',
            contact_name_hint:'La saisie de votre nom est obligatoire',
            contact_title_label:'Titre *',
            contact_title_hint:'La saisie du titre du message est obligatoire',
            contact_email_label:'Votre courriel',
            contact_email_hint:'Ne remplissez ce champ que si vous souhaitez être recontactés',
            contact_text_label:'Texte *',
            contact_text_hint:'La saisie du contenu du message est obligatoire',
            contact_required_fields:'* indique un champ obligatoire',
            contact_nameRules_required:'La saisie de votre nom est obligatoire',
            contact_titleRules_required:'La saisie du titre du message est obligatoire',
            contact_textRules_required:'La saisie du contenu du message est obligatoire',
            contact_too_long:'Trop long',
            contact_optionnal_mail:'Courriel non renseigné',
        }
    },
}
  
//   Create VueI18n instance with options
  const i18n = new VueI18n({
    locale: 'en', // set locale
    messages // set locale messages
  })


const app = new Vue({
    i18n,
    components: { AppComponent },
    router
}).$mount('#app')

// i18n.locale = ''
  