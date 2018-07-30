<template>
  <v-app id="inspire">
 
    <top-nav
        @pageToShow="pageToShow"
        id="topNav">
    </top-nav>

    <main-list
        v-if="page == ''"
        @pageToShow="pageToShow"
        class="adminPage">
    </main-list>

    <edit-category
        v-bind:idSelected="idSelected"
        v-if="page == 'category'"
        class="adminPage">
    </edit-category>

    <edit-reference
        v-if="page == 'reference'"
        class="adminPage">
    </edit-reference>

    <edit-point
        v-if="page == 'point'"
        class="adminPage">
    </edit-point>

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
import TopNav from "./admin/TopNav.vue";
import MainList from "./admin/MainList.vue";
import EditCategory from "./admin/EditCategory.vue";
import EditReference from "./admin/EditReference.vue";
import EditPoint from "./admin/EditPoint.vue";

export default {
      name: "app",
    data() {
        return {
            data: 'nothing',
            page: '',
            idSelected: null,
        };
    },
    methods: {
        //CHANGE PAGE
            pageToShow(newValue, newId) {
                this.page = newValue;
                this.idSelected = newId;
            },  
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
        TopNav,
        MainList,
        EditCategory,
        EditReference,
        EditPoint
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
    .adminList {
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