import Vue from 'vue'

import Vuetify from 'vuetify'
import VueRouter from 'vue-router'

import 'material-design-lite/material.js'

require('../../../node_modules/leaflet/dist/leaflet.css')
require('../../../node_modules/leaflet.markercluster/dist/MarkerCluster.css')
// require('../../../node_modules/geoportal-extensions-leaflet/dist/GpPluginLeaflet.css')

require('./bootstrap');

import App from './App.vue'

Vue.use(Vuetify)
Vue.use(VueRouter)

new Vue({
  el: '#app',
  render: h => h(App)
})
