<template>
  <v-app id="inspire">
 
    <admin-header
        id="adminHeader">
    </admin-header>

    <contact-list
        class="adminPage">
    </contact-list>

  </v-app>
</template>

<script>
import AdminHeader from "./admin/AdminHeader.vue";
import ContactList from "./admin/ContactList.vue";

export default {
      name: "app",
    data() {
        return {
            data: 'nothing',
        };
    },
    methods: {
    },
    mounted() {
            axios.get('/api/dashboard', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(response => {
                this.data = response.data.data
            }).catch(error => {

            })
    },
    components: {
        AdminHeader,
        ContactList,
    }
};

</script>

<style scoped>
    #adminHeader {
        z-index: 3;
        /* position: fixed;
        top: 0;
        width: 100%; */
    }
</style>