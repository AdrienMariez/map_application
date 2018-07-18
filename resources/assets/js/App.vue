<template>
  <v-app id="inspire">
 
    <map-menu id="publicMenu" @drawerMethod="drawerMethod" @displayPoints="displayPoints" @emitLanguage="emitLanguage"></map-menu>

    <locations-map
      id="publicMap"
      v-bind:sender="sender"
      v-bind:pointsDisplayed="pointsDisplayed"
      v-bind:language="language">
    </locations-map>

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
        row
        justify-start
        v-if="drawerCallBack"
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
import MapMenu from "./components/MapMenu.vue";
import LocationsMap from "./components/LocationsMap.vue";

export default {
  name: "app",
  data() {
    return {
      drawerCallBack: true,
      pointsDisplayed: [],
      language: 0,
      sender: false,
    };
  },
  methods: {
    drawerMethod(updatedDrawer){
      this.drawerCallBack = updatedDrawer;
    },
    displayPoints(referenceClicked, actionSender){
      this.pointsDisplayed = referenceClicked;
      this.sender = actionSender;
    },
    emitLanguage(languageSelected){
      this.language = languageSelected;
    }
  },
  components: {
    LocationsMap,
    MapMenu
  }
};
</script>

<style scoped>
  a {
    color: rgb(146, 221, 123) !important;
    text-decoration: inherit;
  }
  #publicMenu {
    z-index: 50;
  }
  #publicMap {
    z-index: 1;
    height: 100%;
  }
  #footer {
    z-index: 25;
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