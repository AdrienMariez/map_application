<template>
    <router-view></router-view>
</template>

<script>
    import store from '../store';

    export default {
        created() {
            if(store.isLoggedIn) {
                axios.post('api/auth/me')
                .then(response => {
                    store.commit('setUser', response.data.data);
                })
                .catch(error => {
                    store.commit('logoutUser');
                    this.$router.push({ name: 'login' });
                });
            }
        }
    }
</script>