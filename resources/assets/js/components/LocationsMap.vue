<template>
  <v-card dark tile flat id="mapContainer">
    
    <div id="map">
    </div>

    <map-controls id="controls" v-model="zoomLevel" @input="input"></map-controls>

  </v-card>
</template>

<script>
// import 'leaflet'
// import 'leaflet.markercluster'
require('../../../../node_modules/leaflet/dist/leaflet.css')
require('../../../../node_modules/leaflet.markercluster/dist/MarkerCluster.css')
import MapControls from './MapControls.vue'

const L = window.L;
export default {
  data() {
    return {
      map: [],
      markers: null,
      zoom: 14,
      zoomLevel: 14
    }
  },
  computed: {
    places() {
      return this.$store.state.places
    },
    center() {
      return this.$store.state.locationsMap.center
    },
    setZoomPosition() {
      var mapHalfHeight = map.getSize().y / 2,
          container = map.zoomControl.getContainer(),
          containerHalfHeight = parseInt(container.offsetHeight / 2),
          containerTop = mapHalfHeight - containerHalfHeight + 'px';
      
      container.style.position = 'absolute';
      container.style.top = containerTop;
    }
  },
  watch: {
    places(val) {
      this.removePlaces()
      this.addPlaces(val)
    },
    center(location) {
      this.map.setView([location.lat, location.lng], location.zoom)
    }
  },
  methods: {
    addPlaces(places) {
      // TO REMOVE all comments here are to disable marker cluster
      if(!this.map) return;
      const map = this.map
      // const markers = L.markerClusterGroup();
      const store = this.$store;

      places.forEach( (place) => {
        let marker = L.marker([place.location.lat, place.location.lng])
            .on('click', (el) => {
              store.commit('locationsMap_center', el.latlng)
            })
            .bindPopup(`<b> ${place.id} </b> ${place.name}`)
        map.addLayer(marker)
        // .on('click', (el) => alert(el.target))
      })

      // map.addLayer(markers)
      // this.markers = markers
    },
    removePlaces() {
      this.map.removeLayer(this.marker)
      this.marker = null
    },
    input(newValue) {
      // ALGO : 
        //I need to watch so that the user can still scroll to zoom in, meaning that the current zoom (x) must be modified, no the value saved (y).
        // aside source :
        //http://bl.ocks.org/oriolbx/f9a75b1dc017e7a8af2a
        //https://leafletjs.com/examples/zoom-levels/

        // zoom initial : 14 (not modified in any way)

        // zoom value : y

        // zoom current: x

        // zoom change : +1
        // OR
        // zoom change : -1

        // y = x
      
        // following value of x : (x = y)

        // y = y + (zoom change)
        // following value of x : (x = x)
        // x = y

        // following value of x : (x = y)

      this.zoomLevel = this.map.getZoom();

      this.zoomLevel+=newValue;

      this.map.setZoom(this.zoomLevel);
    }
  },
  mounted() {
    // CHANGE ME map creation
      //look at this :
      //https://www.geoportail.gouv.fr/tutoriels
      //https://geoservices.ign.fr/documentation/utilisation_web/extension-leaflet.html#download
      //https://geoservices.ign.fr/documentation/utilisation_web/sdk.html

      // L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
      //   minZoom: 10,
      //   maxZoom: 18,
      //   id: 'mapbox.streets',
      //   accessToken: 'pk.eyJ1IjoiYmlib3VuIiwiYSI6ImNqaGhvdTc1ZzAyYXIzZW5yN3ZnaThrdnMifQ.-m9db8kuRMAOEiSsdvQTQA'
      //   zoomControl: false
      // }).addTo(map);

      // const map = L.map('map').setView([44.5040577, 1.1874496], this.zoom)
      // L.tileLayer('https://{s}.tiles.mapbox.com/v4/{user}.{mapId}/{z}/{x}/{y}.png?access_token={token}', {
      //   attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
      //   maxZoom: 18,
      //   mapId: 'mapbox.streets',
      //   user: 'skycatch-dev',
      //   token: 'pk.eyJ1Ijoic2t5Y2F0Y2gtZGV2IiwiYSI6Ik1PVjVYNEkifQ.j2X9OOZDz7ABqUvHk4kesw',
      //   zoomControl: false
      // }).addTo(map);

      // map : mapbox.streets
      //satellite : i81oam9h

      const map = L.map('map').setView([44.5040577, 1.1874496], this.zoom)
      L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        minZoom: 10,
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiYmlib3VuIiwiYSI6ImNqaGhvdTc1ZzAyYXIzZW5yN3ZnaThrdnMifQ.-m9db8kuRMAOEiSsdvQTQA',
        zoomControl: false
      }).addTo(map);

      this.map = map;
      this.addPlaces(this.places);
      
      map.zoomControl.remove();
      // map.touchZoom.disable();
      // map.doubleClickZoom.disable();
      // map.scrollWheelZoom.disable();
      // map.boxZoom.disable();
      // map.keyboard.disable();
      // L.touchZoom.disable();
      // L.doubleClickZoom.disable();
      // L.scrollWheelZoom.disable();
      // L.boxZoom.disable();
      // L.keyboard.disable();
      // L.zoomControl.remove();

    // zoom controls disabled, manual control with user friendly buttons will be used instead

      // 
        // map.zoomControl.setPosition('bottomright');

        // var mapHalfHeight = map.getSize().y / 2,
        //     container = map.zoomControl.getContainer(),
        //     containerHalfHeight = parseInt(container.offsetHeight / 2),
        //     containerTop = mapHalfHeight - containerHalfHeight + 'px';

        // container.style.position = 'absolute';
        // container.style.top = containerTop;


      // 
        // L.control.remove();
        // L.control.zoom({
        //   position:'topright'
        // }).addTo(map);
  },
  components: {
    MapControls,
  }
}
</script>

<style scoped>
  #mapContainer{
    height: 100%;
    width: 100%;
    position: relative;
  }
  #controls{
    width: 100px;
    height: 100px;
    position: absolute;
    top: 50px;
    z-index: 150;
    right: 10px;
  }
  #map{
    /* left as comment to remember NOT to try to use it */
    /* position: initial !important; */
    height: 100%;
    width: 100%;
    z-index: 1;
  }
  .leaflet-bottom .leaflet-control .leaflet-control-zoom .leaflet-bar .leaflet-control{
    margin-bottom: 40px !important;
  }
</style>
