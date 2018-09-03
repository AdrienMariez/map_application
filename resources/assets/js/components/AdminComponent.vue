<template>
  <v-app id="inspire">
 
    <admin-header
        @pageToShow="pageToShow"
        id="adminHeader">
    </admin-header>

    <main-list
        v-if="page == ''"
        v-bind:categories="categories"
        v-bind:categoriesNames="categoriesNames"
        v-bind:references="references"
        v-bind:referenceNames="referenceNames"
        v-bind:points="points"
        v-bind:pointsContents="pointsContents"
        @pageToShow="pageToShow"
        class="adminPage">
    </main-list>

    <edit-category
        v-bind:idSelected="idSelected"
        v-bind:categories="categories"
        v-bind:categoriesNames="categoriesNames"
        v-if="page == 'category'"
        @pageToShow="pageToShow"
        class="adminPage">
    </edit-category>

    <edit-reference
        v-bind:idSelected="idSelected"
        v-bind:page="page"
        v-bind:categories="categories"
        v-bind:categoriesNames="categoriesNames"
        v-bind:references="references"
        v-bind:referenceNames="referenceNames"
        @pageToShow="pageToShow"
        v-if="page == 'reference' || page == 'referenceParent'"
        class="adminPage">
    </edit-reference>

    <edit-point
        v-bind:idSelected="idSelected"
        v-bind:page="page"
        v-bind:categories="categories"
        v-bind:categoriesNames="categoriesNames"
        v-bind:references="references"
        v-bind:referenceNames="referenceNames"
        v-bind:points="points"
        v-bind:pointsContents="pointsContents"
        @pageToShow="pageToShow"
        v-if="page == 'point' || page == 'pointParent'"
        class="adminPage">
    </edit-point>

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
    import MainList from "./admin/MainList.vue";
    import EditCategory from "./admin/EditCategory.vue";
    import EditReference from "./admin/EditReference.vue";
    import EditPoint from "./admin/EditPoint.vue";

    import categoriesMethods from './../services/categories.js'
    import referencesMethods from './../services/references.js'
    import pointsMethods from './../services/points.js'

export default {
      name: "app",
    data() {
        return {
            data: 'nothing',

            categories: [],
            categoriesNames: [],

            references: [],
            referenceNames: [],

            points: [],
            pointsContents: [],

            page: '',
            idSelected: null,
        };
    },
    methods: {
        //CHANGE PAGE
            pageToShow(newValue, newId) {
                this.points = pointsMethods.readPoints();
                this.pointsContents = pointsMethods.readPointsPopupContent();
                this.references = referencesMethods.readReferences();
                this.referenceNames = referencesMethods.readReferenceNames();
                this.categories = categoriesMethods.readCategories();
                this.categoriesNames = categoriesMethods.readCategoriesNames();
                
                this.page = newValue;
                this.idSelected = newId;
            },  
        //API CALLS
            methodsApiCalls() {
                this.points = pointsMethods.readPoints();
                this.pointsContents = pointsMethods.readPointsPopupContent();
                this.references = referencesMethods.readReferences();
                this.referenceNames = referencesMethods.readReferenceNames();
                this.categories = categoriesMethods.readCategories();
                this.categoriesNames = categoriesMethods.readCategoriesNames();
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
    created() {
        this.methodsApiCalls();
    },
    components: {
        AdminHeader,
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
        margin-left: 4px;
    }
    #adminHeader {
        z-index: 3;
        /* position: fixed;
        top: 0;
        width: 100%; */
    }
    .adminList {
        z-index: 1;
    }
    /* #footer {
        z-index: 2;
    } */
    .flexFooterPosition {
        justify-content: center;
        /* if need to get it at start position : */
        /* justify-content: flex-start; */
    }
    .flexCenter {
        justify-content: center;
    }
</style>