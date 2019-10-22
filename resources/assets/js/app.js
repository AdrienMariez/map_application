
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');

import '@mdi/font/css/materialdesignicons.css'

//import Vuetify from 'vuetify'

import VueI18n from 'vue-i18n'
Vue.use(VueI18n)

require('./bootstrap');

import Vue from 'vue';
import 'vuetify/dist/vuetify.min.css';
import Vuetify from "vuetify";
import colors from 'vuetify/es5/util/colors';

Vue.use(Vuetify, {
  theme: {
    primary: colors.indigo.base,
    info: colors.blue.lighten2,
    accent: colors.green.lighten1,
    error: colors.red.darken2
  }
});

// import 'leaflet/dist/leaflet.css';
// import 'leaflet.markercluster/dist/MarkerCluster.css';
// require('../../../node_modules/leaflet/dist/leaflet.css')
// require('../../../node_modules/leaflet.markercluster/dist/MarkerCluster.css')


// Uncomment below when compiling to production

    // Vue.config.devtools = false
    // Vue.config.debug = false
    // Vue.config.silent = true

// END Uncomment


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
            info:'Info',
            info_legal:'legal mentions',
            info_desc_1:"This website was built during an internship in the Prayssac Cyberbase in partnership with Simplon Occitanie.",
            info_desc_2:"Hosting is done by OVH. Cyberbase phone : 05 65 21 83 92. Township address : 1, Boulevard de la Paix - 46220 PRAYSSAC.",
            info_dev_1:'Developement Mariez Adrien 2018.',
            info_dev_2:'Repository Github',
        }
    },
    fr: {
        message: {
            info:'Info',
            info_legal:'Informations légales',
            info_desc_1:"Ce site a été construit dans le cadre d'un stage dans la Cyberbase de Prayssac en partenariat avec Simplon Occitanie.",
            info_desc_2:"L'hébergement est effectué par OVH. Téléphone Cyberbase : 05 65 21 83 92. Addresse de la mairie : 1, Boulevard de la Paix - 46220 PRAYSSAC.",
            info_dev_1:'Développement Mariez Adrien 2018.',
            info_dev_2:'Ressources sur Github',
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
  