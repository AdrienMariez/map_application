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

  function Point({ id, link, icon, color, longitude, lattitude, image_path, fk_reference_id}) {
    this.id = id;
    this.link = link;
    this.icon = icon;
    this.color = color;
    this.longitude = longitude;
    this.lattitude = lattitude;
    this.image_path = image_path;
    this.fk_reference_id = fk_reference_id;
  }
  function PointName({ id, fk_point_id, fk_language_code, title, description, linkalias}) {
    this.id = id;
    this.fk_point_id = fk_point_id;
    this.fk_language_code = fk_language_code;
    this.title = title;
    this.description = description;
    this.linkalias = linkalias;
  }
  function Reference({ id, icon, color, weight, fk_category_id}) {
    this.id = id;
    this.icon = icon;
    this.color = color;
    this.weight = weight;
    this.fk_category_id = fk_category_id;
  }

  //IMPORTS
    //TEST : are those import really necessary ?
    require('../../../../../node_modules/leaflet/dist/leaflet.css')
    require('../../../../../node_modules/leaflet.markercluster/dist/MarkerCluster.css')
    // require('../../../../../node_modules/geoportal-extensions-leaflet/dist/GpPluginLeaflet.css')

    import MapControls from './MapControls.vue'
    // import PointDisplayComponent from './PointDisplay.vue';
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
      pointsCount: 0,
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
    //POINTS POPUP CONTENT READ
      readPointsPopupContent() {
        this.mute = true;
        
        window.axios.get('/api/pointsnames').then(({ data }) => {
          data.forEach(pointContent => {
            this.pointsContents.push(new PointName(pointContent));
          });
          this.mute = false;
        });
      },

    //REFERENCES READ
      readReferences() {
        window.axios.get('/api/references').then(({ data }) => {
          
          data.forEach(reference => {
            this.references.push(new Reference(reference));
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

        // console.log("pointsDisplayed");
        // console.log(pointsDisplayed);
          
        // console.log("storagePointsDisplayed");
        // console.log(storagePointsDisplayed);
          
        // console.log("storagePointsDisplayed.length : "+storagePointsDisplayed.length);
        // console.log("references.length : "+ references.length);

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
        // else if(storagePointsDisplayed.length == 0 && references.length >= 1){
        //   if (localStorage.getItem("referencesDisplayed") !== null){
            // console.log("localstorage was initialized");
            // var localStorageReferenceDisplayed = JSON.parse(localStorage.getItem("referencesDisplayed"));
            // console.log("localStorageReferenceDisplayed.length");
            // console.log(localStorageReferenceDisplayed.length);
            // console.log("this.references.length");
            // console.log(this.references.length);
            
            
            // if (localStorageReferenceDisplayed.length == references.length) {
            //   console.log("ok");
            // }
            // else{
            //   console.log("localStorage emptied");
            //   localStorage.removeItem("referencesDisplayed");
            // }
        //   }
        // }
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
    //SENT EMPTY INFO
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

                        if (point["image_path"].length >= 1) {
                          imgCtnr = document.createElement("div");
                          imgCtnr.setAttribute("style", "width:150px; height:auto;");
                          var img = document.createElement("img");
                          img.setAttribute("style", "width:100%; height:100%;");
                          img.setAttribute("alt", "image");
                          img.setAttribute("src", point["image_path"]);
                          imgCtnr.appendChild(img);
                          
                          popup.appendChild(imgCtnr);
                        }
                        if (content["description"].length >= 1) {
                          desc = document.createElement("div");
                          var descHtml = document.createTextNode(content["description"]);
                          desc.appendChild(descHtml);

                          popup.appendChild(desc);
                        }
                        if (point["link"].length >= 1) {    
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

                    
                    

                    var currentMarker = L.ExtraMarkers.icon({
                      icon: 'fa-'+references[x]["icon"],
                      markerColor: pointsDisplayed[i]["catColor"],
                      shape: 'circle',
                      prefix: 'fa'
                    });
                    marker = L.marker([point["longitude"], point["lattitude"]], {icon: currentMarker}).bindPopup(popup);

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

        // console.log("current : ");
        // console.log(current);
        // console.log("stored :");
        // console.log(str);
        
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
    this.readPoints();
    this.readPointsPopupContent();
    this.readReferences();
  },
  created() {
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
