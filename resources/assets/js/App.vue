<template>
  <v-app id="inspire">
 
    <map-menu id="publicMenu"></map-menu>

    <locations-map id="publicMap"></locations-map>

    <v-footer
      app
      text-xs-center
      align-center
      justify-center
      color="green darken-4"
      id="footer"
      class="text-xs-center flexCenter">
      <span
        class="white--text">
        &copy; 2018 - {{new Date().getFullYear()}} - 
        <a target="_blank" rel="noopener noreferrer" href="http://www.prayssac.fr/">Mairie de Prayssac</a>
      </span>
    </v-footer>

  </v-app>
</template>

<script>

import MapMenu from './components/MapMenu.vue'
import LocationsMap from './components/LocationsMap.vue'

export default {
  name: 'app',
  data () {
    return {
    }
  },
  components: {
    LocationsMap,
    MapMenu
  }
}
</script>

<style>
  a{
    color: rgb(230, 230, 103) !important;
    text-decoration: inherit;
  }
  #publicMenu{
    z-index: 50;
  }
  #publicMap{
    z-index: 1;
    height: 100%
  }
  #footer{
    z-index: 25;
  }
  .flexCenter{
  justify-content: center;
  }
</style>
