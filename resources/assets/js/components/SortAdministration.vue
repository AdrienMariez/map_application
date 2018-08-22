<template>
  <v-app id="inspire">
 
    <admin-header
        id="adminHeader">
    </admin-header>

    <sortable-list
        class="adminPage">
    </sortable-list>

  </v-app>
</template>

<script>
import AdminHeader from "./admin/AdminHeader.vue";
import SortableList from "./admin/SortableList.vue";

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
        SortableList,
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