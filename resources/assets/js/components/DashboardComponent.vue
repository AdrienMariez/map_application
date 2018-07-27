<template>
  <v-app id="inspire">
 
    <top-nav id="topNav">
    </top-nav>

    <main-list id="adminList">
    </main-list>

    <v-footer
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
    </v-footer>

  </v-app>
</template>

<script>
// import MapMenu from "./user/MapMenu.vue";
// import LocationsMap from "./user/LocationsMap.vue";
import TopNav from "./admin/TopNav.vue";
import MainList from "./admin/MainList.vue";

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
        // LocationsMap,
        // MapMenu,
        TopNav,
        MainList
    }
};
</script>

<style scoped>
    a {
        color: rgb(146, 221, 123) !important;
        text-decoration: inherit;
    }
    #topNav {
        z-index: 3;
        /* position: fixed;
        top: 0;
        width: 100%; */
    }
    #adminList {
        z-index: 1;
    }
    #footer {
        z-index: 2;
    }
    .flexFooterPosition {
        justify-content: center;
        /* if need to get it at start position : */
        /* justify-content: flex-start; */
    }
    .flexCenter {
        justify-content: center;
    }
</style>