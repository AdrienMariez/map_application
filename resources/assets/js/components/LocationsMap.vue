<template>
  <v-card dark tile flat id="mapContainer">
    
    <div id="map">
    </div>

    <map-controls id="controls" v-model="zoomLevel" @input="input"></map-controls>

    <!-- TEST NAV -->
          <!-- @displayPoints="displayPoints" -->
        <!-- <point-display-component
          v-for="point in points"
          v-bind="point"
          :key="point.id"
          @displayPoints="displayPoints"
        >
        </point-display-component> -->
    <!-- END TEST NAV -->

  </v-card>
</template>

<script>

  function Point({ id, link, icon, color, longitude, lattitude, uses_image, image_path, fk_reference_id}) {
    this.id = id;
    this.link = link;
    this.icon = icon;
    this.color = color;
    this.longitude = longitude;
    this.lattitude = lattitude;
    this.uses_image = uses_image;
    this.image_path = image_path;
    this.fk_reference_id = fk_reference_id;
  }
  function Reference({ id, icon, color, weight, fk_category_id}) {
    this.id = id;
    this.icon = icon;
    this.color = color;
    this.weight = weight;
    this.fk_category_id = fk_category_id;
  }

// import 'leaflet'
// import 'leaflet.markercluster'
require('../../../../node_modules/leaflet/dist/leaflet.css')
require('../../../../node_modules/leaflet.markercluster/dist/MarkerCluster.css')
require('../../../../node_modules/geoportal-extensions-leaflet/dist/GpPluginLeaflet.css')

import MapControls from './MapControls.vue'
import PointDisplayComponent from './PointDisplay.vue';

const L = window.L;

export default {
  props: ['pointsDisplayed','counter'],
  data() {
    return {
      map: [],
      markers: null,
      zoom: 14,
      zoomLevel: 14,
      points: [],
      pointsCount: 0,
      references: [],
      storagePointsDisplayed: [],
      pointsMarkers: [],
      pointsLayers: [],
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
    center(location) {
      this.map.setView([location.lat, location.lng], location.zoom)
    },

    counter(val, oldVal) {
      this.createMarkers();
    },
  },
  methods: {
    //TO REMOVE
      // addPlaces(places) {
      //   // TO REMOVE all comments here are to disable marker cluster
      //   if(!this.map) return;
      //   const map = this.map
      //   // const markers = L.markerClusterGroup();
      //   const store = this.$store;

      //   places.forEach( (place) => {
      //     let marker = L.marker([place.location.lat, place.location.lng])
      //         .on('click', (el) => {
      //           store.commit('locationsMap_center', el.latlng)
      //         })
      //         .bindPopup(`<b> ${place.id} </b> ${place.name}`)
      //     map.addLayer(marker)
      //     // .on('click', (el) => alert(el.target))
      //   })

      //   // map.addLayer(markers)
      //   // this.markers = markers
      // },
      // removePlaces() {
      //   this.map.removeLayer(this.marker)
      //   this.marker = null
      // },
    //END TO REMOVE
    //CREATION OF MAP
      readMap(){
        const map = L.map('map').setView([44.5040577, 1.1874496], this.zoom);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            minZoom: 10,
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoiYmlib3VuIiwiYSI6ImNqaGhvdTc1ZzAyYXIzZW5yN3ZnaThrdnMifQ.-m9db8kuRMAOEiSsdvQTQA',
            zoomControl: false
        }).addTo(map);

        this.map = map;

        map.zoomControl.remove();
      },
    //POINTS READ
      readPoints() {
        this.mute = true;
        
        window.axios.get('/api/points').then(({ data }) => {
          data.forEach(point => {
            //looping for each object "point"        
            this.points.push(new Point(point));
            this.pointsCount++;
          });
          this.mute = false;
        });
      },
    //REFERENCES READ
      readReferences() {
        window.axios.get('/api/references').then(({ data }) => {
          data.forEach(reference => {
            var obj = {};
            obj["id"] = reference.id;
            obj["isToBeDisplayed"] = false;
            this.storagePointsDisplayed.push(obj);
          });
        });
      },
    //CREATE MARKERS
      createMarkers() {
        var pointsDisplayed = JSON.parse(JSON.stringify(this.pointsDisplayed));

        var storagePointsDisplayed = JSON.parse(JSON.stringify(this.storagePointsDisplayed));

        var points = JSON.parse(JSON.stringify(this.points));

        var markers = this.pointsMarkers;
        var layers = this.pointsLayers;
        var marker;

        for (let i = 0; i < pointsDisplayed.length; i++) {
          
          if(pointsDisplayed[i]["isToBeDisplayed"] != storagePointsDisplayed[i]["isToBeDisplayed"] && pointsDisplayed[i]["isToBeDisplayed"] == true){

            layers[i] = new L.layerGroup();
            
            points.forEach(point => {

              if (point["fk_reference_id"] == pointsDisplayed[i]["id"]) {
                  marker = L.marker([point["longitude"], point["lattitude"]]).bindPopup(point["link"]);
                  layers[i].addLayer(marker);
              }
            });

            this.map.addLayer(layers[i]);

          }
          else if(pointsDisplayed[i]["isToBeDisplayed"] != storagePointsDisplayed[i]["isToBeDisplayed"] && pointsDisplayed[i]["isToBeDisplayed"] == false){
            this.map.removeLayer(layers[i]);
          }
        }

        //stock values
        this.pointsMarkers = markers;
        this.pointsLayers = layers;

        this.storagePointsDisplayed = pointsDisplayed;
      },
    //GET ZOOM
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
      },
  },
  mounted() {
    this.readMap();
    this.readPoints();
    this.readReferences();
  },
  created() {
    // this.createMarkers();
    // console.log("created = storagePointsDisplayed"); 
    // console.log(this.storagePointsDisplayed); 
  },
  components: {
    MapControls,
    PointDisplayComponent
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
