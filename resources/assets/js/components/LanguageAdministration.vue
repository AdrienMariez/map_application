<template>
  <v-app id="inspire">
 
    <admin-header
        id="adminHeader">
    </admin-header>

    <language-list
        class="adminPage">
    </language-list>

    <!-- <v-footer
      app
      text-xs-center
      align-center
      justify-center
      dark
      color="grey darken-3"
      id="footer"
      class="text-xs-center flexFooterPosition">
      <v-layout
        align-center
        class="">
        <div class="hidden-xs-only">
          &copy; 2018 - {{new Date().getFullYear()}} - 
        </div>
        <a target="_blank" rel="noopener noreferrer" href="http://www.prayssac.fr/">Mairie de Prayssac</a>
      </v-layout>
    </v-footer> -->

  </v-app>
</template>

<script>
import AdminHeader from "./admin/AdminHeader.vue";
import LanguageList from "./admin/LanguageList.vue";

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
        LanguageList,
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