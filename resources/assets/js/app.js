import router from './routes.js';
import AppComponent from './components/AppComponent'

const app = new Vue({
    components: { AppComponent },
    router
}).$mount('#app')