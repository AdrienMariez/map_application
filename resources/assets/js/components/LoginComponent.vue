<template>
    <div>

        <admin-header
            id="adminHeader">
        </admin-header>

        <div class="text-center form-wrapper">
            <form class="form-signin" v-on:submit.prevent="submitLogin">
                <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Connection administrateur</h1>

                <label for="inputEmail" class="sr-only">Email</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="Courriel" required autofocus v-model="email">

                <label for="inputPassword" class="sr-only">Mot de passe</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required v-model="password">

                <button class="btn btn-lg green lighten-4 btn-block" type="submit">Connection</button>
            </form>
        </div>

        <v-footer
            app
            text-xs-center
            align-center
            justify-center
            dark
            color="grey darken-3"
            id="footer"
            class="text-xs-center white--text">
            <v-layout
                align-center
                class="">
                <div class="hidden-xs-only">
                &copy; 2018 - {{new Date().getFullYear()}} - 
                </div>
                <a target="_blank" rel="noopener noreferrer" href="http://www.prayssac.fr/">Mairie de Prayssac</a>
            </v-layout>
        </v-footer>

    </div>
</template>

<script>
    import store from '../store'
    import AdminHeader from "./admin/AdminHeaderNoNav.vue";

    export default {
        data() {
            return {
                email: '',
                password: '',
                loginError: false,
            }
        },
        methods: {
            submitLogin() {
                this.loginError = false;
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    // login user, store the token and redirect to dashboard
                    store.commit('loginUser')
                    localStorage.setItem('token', response.data.access_token)
                    this.$router.push({ name: 'admin' })
                }).catch(error => {
                    this.loginError = true
                });
            }
        },
        components: {
            AdminHeader
        }
    }
</script>

<style scoped>
    #adminHeader {
        z-index: 3;
    }
    .form-wrapper {
        min-height: 100%;
        height: 80vh;
        display: flex;
        align-items: center;
    }
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    #footer {
        z-index: 2;
    }
    a {
        color: rgb(146, 221, 123) !important;
        text-decoration: inherit;
        margin-left: 4px;
    }
</style>