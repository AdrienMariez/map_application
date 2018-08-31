<template>
  <v-card dark tile flat id="mapContainer">
    
    <div id="map">
    </div>

    <map-controls id="controls"
      v-model="zoomLevel"
      @zoomValue="zoomValue"
      @setHomePosition="setHomePosition">
    </map-controls>

  </v-card>
</template>

<script>

  //IMPORTS
    // OBSOLETE not required for map to work
    // require('../../../../../node_modules/leaflet/dist/leaflet.css')
    // require('../../../../../node_modules/leaflet.markercluster/dist/MarkerCluster.css')

    import MapControls from './MapControls.vue'
    import pointsMethods from './../../services/points.js'
    import imagesMethods from './../../services/images.js'
  //END IMPORTS

const L = window.L;

export default {
  props: ['pointsDisplayed','sender','language'],
  data() {
    return {
      map: [],
      markers: null,
      mapLat: 44.5040577,
      mapLong: 1.1874496,
      zoom: 14,
      zoomLevel: 14,
      points: [],
      pointsContents: [],
      images: [],
      references: [],
      storagePointsDisplayed: [],
      pointsMarkers: [],
      pointsLayers: [],
      initialization: true,
    }
  },
  watch: {
    center(location) {
      this.map.setView([location.lat, location.lng], location.zoom)
    },
    sender(val, oldVal) {
      this.middlemanCreateMarkers();
    },
    references(val, oldVal) {
      this.middlemanCreateMarkers();
    },
  },
  methods: {
    //CREATION OF MAP
      readMap(){
        const map = L.map('map').setView([this.mapLat,this.mapLong], this.zoom);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            minZoom: 10,
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoiYWRyaWVubWFyaWV6IiwiYSI6ImNqbGRqMXFuZzBidXIzcG95M2FyMWwyazkifQ.zhV0yppFnp7JaXT_cCDSuA',
            zoomControl: false
        }).addTo(map);

        var southWest = L.latLng(44.392567, 1.027538);
        var northEast = L.latLng(44.590387, 1.360224);
        var bounds = L.latLngBounds(southWest, northEast);

        map.setMaxBounds(bounds);
        map.on('drag', function() {
            map.panInsideBounds(bounds, { animate: false });
        });

        this.map = map;

        map.zoomControl.remove();
      },
    //
    //API CALLS
      methodsApiCalls() {
        this.points = pointsMethods.readPoints();
        this.pointsContents = pointsMethods.readPointsPopupContent();
        this.images = imagesMethods.readImages();
        // This method is outside the file as 2 tables are pushed, and if I move the this.references.push(reference); the whole app stops working.
        window.axios.get('/api/references').then(({ data }) => {
          data.forEach(reference => {
            this.references.push(reference);
            var obj = {};
            obj["id"] = reference.id;
            obj["isToBeDisplayed"] = false;
            obj["catColor"] = "";
            this.storagePointsDisplayed.push(obj);
          });
        });
      },
    //MIDDLEMAN
      middlemanCreateMarkers(){
        var pointsDisplayed = JSON.parse(JSON.stringify(this.pointsDisplayed));
        var storagePointsDisplayed = JSON.parse(JSON.stringify(this.storagePointsDisplayed));
        var references = JSON.parse(JSON.stringify(this.references));

        if (storagePointsDisplayed.length >= 1 && references.length >= 1){

          if (this.initialization === true ) {
            // console.log("get local storage");
            this.getLocalStorage()
          }
          else{
            // console.log("point was clicked");
            this.createMarkers(pointsDisplayed, storagePointsDisplayed);
          }
        }
        else{
          // console.log("nothing useful was found");
        }
      },
    //GET LOCAL STORAGE
      getLocalStorage(){
        // console.log("getLocalStorage");
        if (localStorage.getItem("referencesDisplayed") !== null){
          var storagePointsDisplayed = JSON.parse(JSON.stringify(this.storagePointsDisplayed));
          var localStorageReferenceDisplayed = JSON.parse(localStorage.getItem("referencesDisplayed"));

          if (localStorageReferenceDisplayed.length === storagePointsDisplayed.length) {

            var localStorageCheck = true;
            for (let i = 0; i < storagePointsDisplayed.length; i++) {

              if (storagePointsDisplayed[i]["id"] !== localStorageReferenceDisplayed[i]["id"]) {
                localStorageCheck = false;
              }
            }
            
            if (localStorageCheck === false) {
              localStorage.removeItem("referencesDisplayed");
              this.sendDummyInfo();
            }
            else{
              this.createMarkers(localStorageReferenceDisplayed, storagePointsDisplayed);

              var str = JSON.parse(JSON.stringify(localStorageReferenceDisplayed));

              this.$emit('emitLocalStorage', localStorageReferenceDisplayed);
            }
          }
          else{
            localStorage.removeItem("referencesDisplayed");
            this.sendDummyInfo();
          }
        }
        else{
          this.sendDummyInfo();
        }
        this.initialization = false;
      },
    //SEND EMPTY INFO
      sendDummyInfo(){
        var emptyInitialReferences = [];
        this.references.forEach(reference => {
          var obj = {};
          obj["id"] = reference.id;
          obj["isToBeDisplayed"] = false;
          obj["catColor"] = "";
          emptyInitialReferences.push(obj);
        });
        this.$emit('emitLocalStorage', emptyInitialReferences);
      },
    //CREATE MARKERS
      createMarkers(pointsDisplayed, storagePointsDisplayed) {
        var dp = JSON.parse(JSON.stringify(pointsDisplayed));
        // console.log(storagePointsDisplayed);
           
        // var pointsDisplayed = JSON.parse(JSON.stringify(this.pointsDisplayed));

        var references = JSON.parse(JSON.stringify(this.references));

        var points = JSON.parse(JSON.stringify(this.points));

        var pointsContents = JSON.parse(JSON.stringify(this.pointsContents));

        var images = JSON.parse(JSON.stringify(this.images));  

        var markers = this.pointsMarkers;
        var layers = this.pointsLayers;
        var marker;
        
        for (let i = 0; i < pointsDisplayed.length; i++) {
          
          if(pointsDisplayed[i]["isToBeDisplayed"] != storagePointsDisplayed[i]["isToBeDisplayed"] && pointsDisplayed[i]["isToBeDisplayed"] == true){
            
            layers[i] = new L.layerGroup();

            //for each layer to display, create the points
            points.forEach(point => {

              if (point["fk_reference_id"] == pointsDisplayed[i]["id"]) {

                for (let x = 0; x < references.length; x++) {

                  if (references[x]["id"] == pointsDisplayed[i]["id"]) {
                    var title;
                    var desc = "";
                    var link = "";
                    var imgCtnr = "";
                    var popup = document.createElement("div");
                    popup.setAttribute("style", "text-align:center;");

                    pointsContents.forEach(content => {
                      if (content["fk_point_id"] == point["id"] && content["fk_language_code"] == this.language) {
                        title = document.createElement("h3");
                        var titleHtml = document.createTextNode(content["title"]);
                        title.appendChild(titleHtml);
                        popup.appendChild(title);

                        if (point["fk_image_id"]!== null) {
                          imgCtnr = document.createElement("div");
                          imgCtnr.setAttribute("style", "width:150px; height:auto; margin-left:auto; margin-right:auto;");
                          var img = document.createElement("img");
                          img.setAttribute("style", "width:100%; height:100%;");
                          img.setAttribute("alt", "image");
                          
                          for (let im = 0; im < images.length; im++) {
                            if (images[im]["id"] == point["fk_image_id"]) {
                              img.setAttribute("src", images[im]["image_path"]);
                              // console.log("image found :");
                              // console.log(images[im]["image_path"]);
                              
                            }
                          }

                          imgCtnr.appendChild(img);
                          
                          popup.appendChild(imgCtnr);
                        }
                        if (content["description"].length >= 1) {
                          desc = document.createElement("div");
                          var descHtml = document.createTextNode(content["description"]);
                          desc.appendChild(descHtml);

                          popup.appendChild(desc);
                        }
                        if (point["link"]) {
                          link = document.createElement("a");
                          link.setAttribute("target", "_blank");
                          link.setAttribute("rel", "noopener noreferrer");
                          link.setAttribute("href", point["link"]);
                          var linkHtml;
                          if (content["linkalias"].length >= 1) {
                            var linkHtml = document.createTextNode(content["linkalias"]);
                            // link += content["linkalias"];
                          }
                          else{
                            var linkHtml = document.createTextNode(point["link"]);
                            // link += point["link"];
                          }
                          link.appendChild(linkHtml);

                          popup.appendChild(link);
                        }
                      }
                    });
                    
                    var currentMarker;

                    if (references[x]["icon"].substring(0,3) == "fa-") {
                      currentMarker = L.ExtraMarkers.icon({
                        icon: references[x]["icon"],
                        markerColor: pointsDisplayed[i]["catColor"],
                        shape: 'circle',
                        prefix: 'fa'
                      });
                    }
                    else{
                      currentMarker = L.ExtraMarkers.icon({
                        icon: references[x]["icon"],
                        markerColor: pointsDisplayed[i]["catColor"],
                        shape: 'circle',
                        prefix: 'mdi'
                      });
                    }
                    

                    marker = L.marker([point["lattitude"], point["longitude"]], {icon: currentMarker}).bindPopup(popup);

                    // marker = L.marker([point["longitude"], point["lattitude"]]).bindPopup(point["link"]);

                    layers[i].addLayer(marker); 
                  }
                }

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

        var current = JSON.parse(JSON.stringify(pointsDisplayed));
        var str = JSON.parse(JSON.stringify(storagePointsDisplayed));
        
        this.storagePointsDisplayed = pointsDisplayed;
      },
    //GET ZOOM
      zoomValue(newValue) {
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

        //END ALGO

        this.zoomLevel = this.map.getZoom();

        this.zoomLevel+=newValue;

        this.map.setZoom(this.zoomLevel);   
      },
    //SET BACK TO HOME POSITION
      setHomePosition() {
        this.zoomLevel = this.map.getZoom();

        this.map.setView(new L.LatLng(this.mapLat,this.mapLong), this.zoom);
      },
  },
  mounted() {
    this.readMap();
    this.methodsApiCalls();
  },
  components: {
    MapControls,
    // PointDisplayComponent
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
  .leaflet-popup .leaflet-popup-content{
    text-align: center !important;
  }
  .flexCenter {
    justify-content: center;
  }
</style>
