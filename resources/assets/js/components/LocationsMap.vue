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
    // updateOfPoints(pointsDisplayed) {
    //   console.log("pointsDisplayed");
    //   console.log(pointsDisplayed);
    // },
    // places(val) {
    //   this.removePlaces()
    //   this.addPlaces(val)
    // },
    center(location) {
      this.map.setView([location.lat, location.lng], location.zoom)
    },

    counter(val, oldVal) {
      // console.log('Prop changed: ', val, ' | was: ', oldVal);
      
      var pointsDisplayed = JSON.parse(JSON.stringify(this.pointsDisplayed));

      var storagePointsDisplayed = JSON.parse(JSON.stringify(this.storagePointsDisplayed));

      var points = JSON.parse(JSON.stringify(this.points));

      //trying stuff
      var markers = [];
      var layers = [];
      var marker;
      
      
      if(storagePointsDisplayed.length < 1){
        // console.log("too short ! changed !");
        storagePointsDisplayed = JSON.parse(JSON.stringify(this.pointsDisplayed));
        // console.log("storagePointsDisplayed before loop");
        // console.log(storagePointsDisplayed);
        //if too small look for the false or change the storagePointsDisplayed to be pointsDisplayed but all true
        for (let i = 0; i < storagePointsDisplayed.length; i++) {
          if(storagePointsDisplayed[i]["isToBeDisplayed"] == true){
            // console.log(storagePointsDisplayed[i]);
            storagePointsDisplayed[i]["isToBeDisplayed"] = false
          }
        }
        for (var i = 0; i < pointsDisplayed.length; i++) {
          markers[i] = [];
        }
      }
      else{
        markers = this.pointsMarkers;
        layers = this.pointsLayers;
      }
      // console.log("storagePointsDisplayed after loop");
      // console.log(storagePointsDisplayed);
      // console.log("pointsDisplayed");
      // console.log(pointsDisplayed);

      for (let i = 0; i < pointsDisplayed.length; i++) {
      // console.log("loop in categories");

        if(pointsDisplayed[i]["isToBeDisplayed"] != storagePointsDisplayed[i]["isToBeDisplayed"]){
        //If a difference with the previous state is detected...
          // console.log("occurence !");
          // console.log(pointsDisplayed[i]);
          //xar
          layers[i] = new L.layerGroup();

          // if (pointsDisplayed[i]["isToBeDisplayed"] == true) {
          //If it is asked to display the new points...
            // var m = L.marker([point["longitude"], point["lattitude"]])
            //   .bindPopup(point["link"])
            //   .addTo(this.map);
            console.log("add the points !");
            points.forEach(point => {
              if (point["fk_reference_id"] == pointsDisplayed[i]["id"]) {
                marker = L.marker([point["longitude"], point["lattitude"]]).bindPopup(point["link"]);
                //xar
                if (pointsDisplayed[i]["isToBeDisplayed"] == true) {
                  marker.setOpacity(1);
                }
                else{
                  marker.setOpacity(0);
                }
                layers[i].addLayer(marker);
                //xor
                // markers[i].push(marker);
                // layers[i] = L.layerGroup(markers[i]).addTo(this.map);
                console.log("layers");
                console.log(layers);

                // console.log("layers creation",i);
                // console.log(layers[i]);
              }
            });
            //xar
            this.map.addLayer(layers[i]);
            // layers[i] = L.featureGroup(markers[i]).addTo(this.map);

          // }
          // else{
          //   console.log("remove the points !");
          //   // layers[i] = [];
          //   // layers[i] = L.layerGroup(layers[i]).removeFrom(this.map);

          //   // console.log("layers");
          //   // console.log(layers);
          //   console.log("layers removal",i);
          //   console.log(layers[i]);
          //   // this.map.addLayer(layers[i]);
          //   this.map.removeLayer(layers[i]);
          //   // console.log("layers after");
          //   // console.log(layers);
          //   // layers[i] = L.layerGroup(markers[i]).removeFrom(this.map);
          // }
          
          // pointsDisplayed[i]["id"]
        }
      }

      // this.map.eachLayer(function (layer) {
      //     console.log(layer);
      // });

      // for (let y = 0; y < pointsDisplayed.length; y++) {
      //   this.map.removeLayer(layers); 
      // }
      //trying stuff
      // console.log(markers);

      //stock values
      this.pointsMarkers = markers;
      this.pointsLayers = layers;

      this.storagePointsDisplayed = pointsDisplayed;
    },
    // watcher for the props pointsDisplayed. May be useless.
    pointsDisplayed(val, oldVal) {

      // console.log('Prop changed: ', val, ' | was: ', oldVal);
      // console.log("method");
      // for (let i = 0; i < this.pointsDisplayed.length; i++) {
      //   console.log(this.pointsDisplayed[i]);
      // }
      // console.log(val);
      // console.log(val.length);
      // for (let i = 0; i < val.length; i++) {
      //   if (val[i]["isToBeDisplayed"] == true){
      //     var m = L.marker([44.5048, 1.18704])
      //     .bindPopup("text")
      //     .addTo(this.map);

      //     var m = L.marker([44.5060, 1.18700])
      //     .bindPopup("text2")
      //     .addTo(this.map);
      //     console.log(val[i]["isToBeDisplayed"]);
          
      //   }
      //   else{
      //     console.log(val[i]["isToBeDisplayed"]);
      //   }
      // }
      
      // console.log("watcher map");
      // console.log(map);
      // console.log("watcher this.map");
      // console.log(this.map);
      // console.log("watcher this.points");
      // console.log(this.points);

      // var x = this.pointsCount;
      // console.log(x);

      // var m = L.marker([44.5048, 1.18704])
      // .bindPopup("text")
      // .addTo(this.map);

      // var m = L.marker([44.5060, 1.18700])
      // .bindPopup("text2")
      // .addTo(this.map);
      
      
      
      // for (let i = 0; i < x; i++) {
      //   console.log(i);
      //   var m = L.marker([this.points[i].longitude, this.points[i].lattitude])
      //   .bindPopup(this.points[i].color)
      //   .addTo(this.map);
      // }

      // this.displayPoints();
    }
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
    readPoints() {
      this.mute = true;
      
      // const markers = new L.FeatureGroup().addTo(map);

      window.axios.get('/api/points').then(({ data }) => {
        data.forEach(point => {
          //looping for each object "point"
          this.points.push(new Point(point));
          this.pointsCount++;
          
          // console.log("location loop");
          // console.log(point);

          // this.displayPoints(point);
          // const m = L.marker([point.longitude, point.lattitude])
          //   .addTo(map);
          // const p = L.marker([point.lattitude, point.longitude])
          //   .addTo(map);
        });
        this.mute = false;
      });
    },
    // displayPoints(point) {
    //   console.log("back in ussr");
    //   console.log(point);
    // },
    // displayPoints() {
      // var text = '';
      // for (let i = 0; i < this.pointsDisplayed.length; i++) {
      //   console.log(this.pointsDisplayed[i]["isToBeDisplayed"]);
      //   text+=this.pointsDisplayed[i]["id"];
      // }
      // console.log(text);
      
      // var m = L.marker([44.5048, 1.18704])
      // .bindPopup(text)
      // .addTo(map);
    // },
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
      
    map.zoomControl.remove();

    // console.log("map");
    // console.log(map);
    // console.log("this.map");
    // console.log(this.map);
    
    
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
  created() {
    this.readPoints();
    // console.log(this.points); 
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
