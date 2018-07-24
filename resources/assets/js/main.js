import Vue from 'vue';

import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';

import 'material-design-lite/material.js'

require('../../../node_modules/leaflet/dist/leaflet.css')
require('../../../node_modules/leaflet.markercluster/dist/MarkerCluster.css')
// require('../../../node_modules/geoportal-extensions-leaflet/dist/GpPluginLeaflet.css')

require('./bootstrap');


import App from './App.vue';
import AdminApp from './AdminApp.vue';
import Home from './components/AdminHome.vue';
import Register from './components/AdminRegister.vue';
import Login from './components/AdminLogin.vue';
import Dashboard from './components/AdminDashboard.vue';

Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const routes = [
  { path: '/', 
    name: 'app',
    component: App
  },
  { path: '/admin',
    name: 'admin',
    component: AdminApp
  },
  { path: '/home', 
    name: 'homemade',
    component: Home,
    meta: {
      auth: true
    }
  },
  { path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: false
    }
  },
  { path: '/login', 
    name: 'login',
    component: Login,
    meta: {
      auth: false
    }
  },
  { path: '/dashboard', 
    name: 'dashboard',
    component: Dashboard,
    meta: {
      auth: true
    }
  }
]
const router = new VueRouter({
  routes: routes // short for `routes: routes`
});

Vue.router=router


Vue.use(require('@websanova/vue-auth'), {

  auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),

  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),

  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),

});


// const app = new Vue({
//   router,
//   routes
// }).$mount('#app')

const app = new Vue({
  router,
  routes,
  components: { App }
}).$mount('#app')