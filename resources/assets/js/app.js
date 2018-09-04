
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');

import '@mdi/font/css/materialdesignicons.css'

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

// Vue.use(Vuetify)
Vue.use(Vuetify, {
    iconfont: 'md' || 'mdi' || 'fa' || 'fa4'
  })

const messages = {
    en: {
        message: {
            contact:'Contact',
            contact_us:'Contact us',
            contact_desc:'Send us your thoughts or questions !',
            contact_fr_or_en_only:'(French or english only.)',
            contact_name_label:'Your name *',
            contact_name_hint:'Your name is required',
            contact_title_label:'Object *',
            contact_title_hint:'Filling the object form is required',
            contact_email_label:'Your email',
            contact_email_hint:'Fill this field only if you wish to be answered',
            contact_RGPD_hint_1:'According to the GDPR, all of your personnal data, like your email, cannot be used commercially without your agreement and will be stored securely in a server based in European Union.',
            contact_RGPD_hint_2:'As specified by the GDPR, you have the right to request the erasure of all personal data from our database.',
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
            contact_title_label:'Objet *',
            contact_title_hint:"La saisie de l'objet du message est obligatoire",
            contact_email_label:'Votre courriel',
            contact_email_hint:'Ne remplissez ce champ que si vous souhaitez être recontactés',
            contact_RGPD_hint_1:'Conformément à la loi RGPD, toute vos données personnelles, comme votre email, ne pourront être utilisées à des fins commerciales sans votre accord et seront conservées de manière sécurisées et confidentielles sur un serveur situé en Union Européenne.',
            contact_RGPD_hint_2:'Conformément à vos droits, vous pouvez nous faire connaître votre intention de supprimer vos informations personnelles de nos bases de données.',
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
  