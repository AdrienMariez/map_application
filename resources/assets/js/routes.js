import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import AdminComponent from './components/AdminComponent'
import SortAdminComponent from './components/SortAdministration'
import LanguagesAdminComponent from './components/LanguageAdministration'
import ContactAdminComponent from './components/ContactAdministration'
import LoginComponent from './components/auth/LoginComponent'
import ConnexionComponent from './components/auth/ConnexionComponent'
import LogoutComponent from './components/auth/LogoutComponent'
import PublicComponent from './components/PublicComponent'
import ModelComponent from './components/ModelComponent'
import store from './store'

const routes = [
    {
        path: '/',
        name: 'public',
        component: PublicComponent
    },
    //the model component is a work in progress to see if a tool to visualize 3d models could be possible
    {
        path: '/model',
        name: 'model',
        component: ModelComponent
    },
    {
        path: '/admin',
        name: 'admin',
        component: AdminComponent,
        meta: { requiresAuth: true }
    },
    {
        path: '/sort',
        name: 'sort',
        component: SortAdminComponent,
        meta: { requiresAuth: true }
    },
    {
        path: '/languages',
        name: 'languages',
        component: LanguagesAdminComponent,
        meta: { requiresAuth: true }
    },
    {
        path: '/contact',
        name: 'contact',
        component: ContactAdminComponent,
        meta: { requiresAuth: true }
    },
    {
        path: '/cartosprayssacos',
        name: 'login',
        component: LoginComponent
    },
    //the connexion component is a fake login page, it doesn't work !
    {
        path: '/connexion',
        name: 'connexion',
        component: ConnexionComponent
    },
    {
        path: '/logout',
        name: 'logout',
        component: LogoutComponent
    }
]

const router = new VueRouter({
    routes
})

router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'connexion' })
        return
    }

    // if logged in redirect to admin page
    if(to.path === '/login' && store.state.isLoggedIn) {
        next({ name: 'admin' })
        return
    }

    next()
});

export default router
