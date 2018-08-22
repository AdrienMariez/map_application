import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import AdminComponent from './components/AdminComponent'
import SortAdminComponent from './components/SortAdministration'
import LanguagesAdminComponent from './components/LanguageAdministration'
import LoginComponent from './components/auth/LoginComponent'
import LogoutComponent from './components/auth/LogoutComponent'
import PublicComponent from './components/PublicComponent'
import store from './store'

const routes = [
    {
        path: '/',
        name: 'public',
        component: PublicComponent
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
        path: '/login',
        name: 'login',
        component: LoginComponent
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
        next({ name: 'login' })
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
