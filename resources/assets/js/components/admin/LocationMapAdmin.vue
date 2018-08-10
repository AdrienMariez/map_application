<template>
    <v-layout>
        <v-btn
            dark
            fab
            class="fixedButton"
            color="success"
            @click.stop="drawerMap = true">
            <v-icon>add</v-icon>
        </v-btn>
        <v-container>
            <v-layout justify-end>
                <v-btn
                    dark
                    right
                    color="success"
                    @click.stop="drawerMap = true">
                    Montrer la carte
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
                <v-btn
                    color="warning"
                    dark
                    small
                    absolute
                    middle
                    right
                    fab
                    @click.stop="drawerMap = !drawerMap">
                    <v-icon>remove</v-icon>
                </v-btn>
                {{localLattitude}}
                {{localLongitude}}
            </div>
        </v-navigation-drawer>
    </v-layout>
</template>

<script>

    export default {
        props: ['localLattitude', 'localLongitude'],
        data () {
            return {
                drawerMap: false,
            }
        },
        watch: {
            localLattitude(val, oldVal){
                if (isNaN(val)) {
                    console.log("lattitude not a number");
                    this.localLattitude = oldVal;
                }
            },
            localLongitude(val, oldVal){
                if (isNaN(val)) {
                    console.log("longitude not a number");
                    this.localLongitude = oldVal;
                }
            },
        },
        methods: {
            selectImage() {
            },
        },
        created() {
        }
    }
</script>

<style scoped>
    .fixedButton{
        z-index: 4;
        position: fixed;
        top: 100px;
        right: 0px;
    }
    #fixedDrawer{
        top: 5vh;
        /* width: 90vw !important; */
        height: 90vh !important;
    }
    #fixedDrawerContent{
        height: 100% !important;
        width: 100% !important;
        max-width: 80vw !important;
        background-color: rgb(250, 117, 117);
        /* z-index: 6;
        position: fixed;
        top: 5vh;
        width: 90vw;
        height: 90vh;
        background-color: beige; */
    }
</style>