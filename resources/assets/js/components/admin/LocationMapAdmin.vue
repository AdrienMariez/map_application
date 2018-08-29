<template>
    <v-layout>
        <v-btn
            dark
            fab
            class="fixedButton"
            color="success"
            @click.stop="drawerMap = true">
            <v-icon>map</v-icon>
        </v-btn>
        <v-container>
            <v-layout>
                <!-- responsive -->
                <v-btn
                    dark
                    color="success"
                    class="hidden-md-and-up"
                    @click.stop="drawerMap = true">
                    Positionner le point ici !
                </v-btn>
                <!-- desktop -->
                <v-btn
                    dark
                    color="success"
                    class="hidden-sm-and-down"
                    @click.stop="drawerMap = true">
                    Positionner le point sur la carte ici !
                </v-btn>
            </v-layout>
        </v-container>
        <v-navigation-drawer
            v-model="drawerMap"
            fixed
            right
            temporary
            width="1200"
            id="fixedDrawer">
            <div id="fixedDrawerContent">
                    <div id="map">
                    </div>
                    <!-- responsive buttons -->
                    <v-layout
                        v-if="previewMode == false"
                        justify-space-between
                        class="hidden-md-and-up">>
                        <v-btn
                            dark
                            right
                            color="success"
                            class="mx-2"
                            @click.stop="getPointCoord()">
                            <v-icon>check_circle_outline</v-icon>
                        </v-btn>
                        <v-btn
                            dark
                            right
                            color="success"
                            class="mx-2"
                            @click.stop="centerPointCoord()">
                            <v-icon>center_focus_strong</v-icon>
                        </v-btn>
                        <v-btn
                            dark
                            right
                            color="warning"
                            class="mx-2"
                            @click.stop="reinitPointCoord()">
                            <v-icon>highlight_off</v-icon>
                        </v-btn>
                    </v-layout>
                    <!-- responsive preview button -->
                    <v-layout
                        v-if="previewMode"
                        justify-space-between
                        class="hidden-md-and-up">>
                        <v-btn
                            dark
                            right
                            color="warning"
                            class="mx-2"
                            @click.stop="createPositionnedPoint()">
                            <v-icon>highlight_off</v-icon>
                        </v-btn>
                    </v-layout>
                    <!-- desktop buttons -->
                    <v-layout
                        v-if="previewMode == false"
                        justify-space-between
                        class="hidden-sm-and-down">
                        <v-btn
                            dark
                            right
                            color="success"
                            class="mx-2"
                            @click.stop="getPointCoord()">
                            <v-icon>check_circle_outline</v-icon>
                            Mettre à jour la position du point
                        </v-btn>
                        <v-btn
                            dark
                            right
                            color="success"
                            class="mx-2"
                            @click.stop="centerPointCoord()">
                            <v-icon>warning</v-icon>
                            placer le point au centre
                        </v-btn>
                        <v-btn
                            dark
                            right
                            color="warning"
                            class="mx-2"
                            @click.stop="reinitPointCoord()">
                            <v-icon>highlight_off</v-icon>
                            Annuler
                        </v-btn>
                    </v-layout>
                    <!-- desktop preview button -->
                    <v-layout
                        v-if="previewMode"
                        justify-space-between
                        class="hidden-sm-and-down">
                        <v-btn
                            dark
                            right
                            color="warning"
                            class="mx-2"
                            @click.stop="createPositionnedPoint()">
                            <v-icon>highlight_off</v-icon>
                            Retour au mode edition
                        </v-btn>
                    </v-layout>
            </div>
        </v-navigation-drawer>
    </v-layout>
</template>

<script>
    export default {
        props: ['lattitude', 'longitude', 'lattitudeUpdater', 'longitudeUpdater', 'icon', 'markerColor', 'pointPreview', 'preview'],
        data () {
            return {
                initialization: true,
                drawerMap: false,
                //map parameters
                map: [],
                mapLat: 44.5040577,
                mapLong: 1.1874496,
                zoom: 14,
                marker: [],
                pointLattitude: null,
                pointLongitude: null,
                previewMode: false,
            }
        },
        watch: {
            lattitude(val, oldVal){
                this.createPositionnedPoint()
            },
            longitude(val, oldVal){
                this.createPositionnedPoint()
            },
            lattitudeUpdater(val, oldVal){
                if (this.lattitude == null && this.longitude == null) {
                    
                }
                else{
                    this.createPositionnedPoint()
                }
            },
            longitudeUpdater(val, oldVal){
                if (this.lattitude == null && this.longitude == null) {
                    
                }
                else{
                    this.createPositionnedPoint()
                }
                
            },
            preview(val, oldVal){
                this.previewPoint();
            },
        },
        methods: {
            // Creation of map
                readMap(){
                    const map = L.map('map').setView([this.mapLat,this.mapLong], this.zoom);

                    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                        minZoom: 10,
                        maxZoom: 18,
                        id: 'mapbox.streets',
                        accessToken: 'pk.eyJ1IjoiYWRyaWVubWFyaWV6IiwiYSI6ImNqbGRqMXFuZzBidXIzcG95M2FyMWwyazkifQ.zhV0yppFnp7JaXT_cCDSuA'
                    }).addTo(map);

                    var southWest = L.latLng(44.392567, 1.027538);
                    var northEast = L.latLng(44.590387, 1.360224);
                    var bounds = L.latLngBounds(southWest, northEast);

                    map.setMaxBounds(bounds);
                    map.on('drag', function() {
                        map.panInsideBounds(bounds, { animate: false });
                    });

                    this.map = map;

                    this.createCenterPoint();

                },
            // Creation of centered point
                createCenterPoint(){
                    var currentMarker = L.ExtraMarkers.icon({
                      icon: "fa-angle-double-down",
                      markerColor: "#FFC400",
                      shape: 'circle',
                      prefix: 'fa'
                    });

                    this.marker = L.marker([this.mapLat, this.mapLong], {icon: currentMarker, draggable:'true'}).addTo(this.map);

                },
            // Creation of positionned point
                createPositionnedPoint(){
                    this.map.removeLayer(this.marker);

                    this.previewMode = false;

                    this.initialization = false;

                    var currentMarker = L.ExtraMarkers.icon({
                      icon: this.icon,
                      markerColor: this.selectedColor,
                      shape: 'circle',
                      prefix: 'fa'
                    });

                    this.marker = L.marker([this.lattitude, this.longitude], {icon: currentMarker, draggable:'true'}).addTo(this.map);
                },
            // Recenter of positionned point
                centerPointCoord(){
                    this.map.removeLayer(this.marker);
                    this.createCenterPoint()
                },
            // get back to previous state for point
                reinitPointCoord() {
                    if (this.lattitude == null) {
                        this.map.removeLayer(this.marker);
                        this.createCenterPoint();
                    }
                    else{
                        this.createPositionnedPoint();
                    }
                    this.drawerMap = false;
                },
            // Reading point coordinates and sending 'em
                getPointCoord() {
                    var marker = JSON.parse(JSON.stringify(this.marker.getLatLng()));

                    this.$emit('pointLattitudeUpdate', marker.lat);
                    this.$emit('pointLongitudeUpdate', marker.lng);

                    this.drawerMap = false;
                },
            // Creation of Preview point
                previewPoint(){
                    this.previewMode = true;
                    this.drawerMap = true;

                    this.map.removeLayer(this.marker);

                    // Convert colors
                        var color;
                        switch (this.pointPreview.color) {
                            case "#B71C1C":
                                //red darken-4
                                color = "red";
                                break;

                            case "#F4511E":
                                //deep-orange darken-4
                                color = "orange-dark";
                                break;

                            case "#FFA726":
                                //orange lighten-1
                                color = "orange";
                                break;

                            case "#FFC400":
                                //amber accent-3
                                color = "yellow";
                                break;

                            case "#006064":
                                //cyan darken-4
                                color = "blue-dark";
                                break;

                            case "#01579B":
                                //light-blue darken-4
                                color = "blue";
                                break;

                            case "#1E88E5":
                                //blue darken-1
                                color = "cyan";
                                break;

                            case "#4A148C":
                                //purple darken-4
                                color = "purple";
                                break;

                            case "#880E4F":
                                //pink darken-4
                                color = "violet";
                                break;

                            case "#F50057":
                                //pink accent-3
                                color = "pink";
                                break;

                            case "#1B5E20":
                                //green darken-4
                                color = "green-dark";
                                break;

                            case "#388E3C":
                                //green darken-2
                                color = "green";
                                break;

                            case "#4CAF50":
                                //green
                                color = "green-light";
                                break;

                            default:
                                color = catColor;
                        }
                    // END Convert colors

                    var currentMarker;

                    if (this.pointPreview.icon.substring(0,3) == "fa-") {
                      currentMarker = L.ExtraMarkers.icon({
                        icon: this.pointPreview.icon,
                        markerColor: color,
                        shape: 'circle',
                        prefix: 'fa'
                      });
                    }
                    else{
                      currentMarker = L.ExtraMarkers.icon({
                        icon: this.pointPreview.icon,
                        markerColor: color,
                        shape: 'circle',
                        prefix: 'mdi'
                      });
                    }

                    //popup
                        // console.log(this.pointPreview.title);
                        // console.log(this.pointPreview["title"]);
                    
                        var title;
                        var desc = "";
                        var link = "";
                        var imgCtnr = "";
                        var popup = document.createElement("div");
                        popup.setAttribute("style", "text-align:center;");
                        //title
                            title = document.createElement("h3");
                            var titleHtml = document.createTextNode(this.pointPreview.title);
                            title.appendChild(titleHtml);
                            popup.appendChild(title);
                        //img
                            if (this.pointPreview.img != "") {
                                imgCtnr = document.createElement("div");
                            imgCtnr.setAttribute("style", "width:150px; height:auto;");
                            var img = document.createElement("img");
                            img.setAttribute("style", "width:100%; height:100%;");
                            img.setAttribute("alt", "image");
                            img.setAttribute("src", this.pointPreview.img);
                            imgCtnr.appendChild(img);
                            popup.appendChild(imgCtnr);
                            }
                        //desc
                            desc = document.createElement("div");
                            var descHtml = document.createTextNode(this.pointPreview.desc);
                            desc.appendChild(descHtml);
                            popup.appendChild(desc);
                        //link
                        if (this.pointPreview.link != "") {
                            link = document.createElement("a");
                            link.setAttribute("target", "_blank");
                            link.setAttribute("rel", "noopener noreferrer");
                            link.setAttribute("href", this.pointPreview.link);
                            var linkHtml;
                            // link alias
                            var linkHtml = document.createTextNode(this.pointPreview.linkAlias);

                            link.appendChild(linkHtml);

                            popup.appendChild(link);
                        }
                    //END popup

                    this.marker = L.marker([this.pointPreview.lat, this.pointPreview.lng], {icon: currentMarker}).bindPopup(popup).addTo(this.map);
                },
        },
        mounted() {
            this.readMap();
        }
    }
</script>

<style scoped>
    .fixedButton{
        z-index: 4;
        position: fixed;
        top: 30vh;
        right: 0px;
    }
    #fixedDrawer{
        top: 5vh;
        /* width: 90vw !important; */
        height: 90vh !important;
        background-color: white !important;
    }
    #fixedDrawerContent{
        height: 100% !important;
        width: 100% !important;
        max-width: 80vw !important;
        /* z-index: 6;
        position: fixed;
        top: 5vh;
        width: 90vw;
        height: 90vh;
        background-color: beige; */
    }
    #map{
        height: 85%;
        width: 100%;
        position: relative;
    }
</style>