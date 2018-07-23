<template>
    <div>
        <v-card-text class="buttonFly">
            <v-btn
                absolute
                dark
                fab
                center
                color="green lighten-1"
                v-on:click="zoomingIn($event.target.value)"
            >
                <v-icon>zoom_in</v-icon>
            </v-btn>
        </v-card-text>

        <!-- visual help to know how zoomed we are here ? -->

        <v-card-text class="buttonFly">
            <v-btn
                absolute
                dark
                fab
                center
                color="green lighten-1"
                v-on:click="zoomingOut()"
            >
                <v-icon>zoom_out</v-icon>
            </v-btn>
        </v-card-text>

        <v-card-text class="buttonFly">
            <v-btn
                absolute
                dark
                fab
                center
                color="green lighten-1"
                v-on:click="setHomePosition()"
            >
                <v-icon>home</v-icon>
            </v-btn>
        </v-card-text>
    </div>
</template>

<script>

export default {
    props: ['zoomValue'],
    data () {
      return {
          zoomIn: 1,
          zoomOut:-1
      }
    },
    computed: {
      functionName: function() {

      }
    },
    methods: {
        zoomingIn() {
            // var newValue = parseInt(value) + 1;
            //if input is changed, the value does not load properly...
            this.$emit('zoomValue', 1);
        },
        zoomingOut(){
            // var newValue = parseInt(value) - 1;
            this.$emit('zoomValue', -1);
        },
        setHomePosition(){
            this.$emit('setHomePosition');
        },
    }
}
</script>

<style scoped>
    .buttonFly{
        height: 80px;
        width: 80px;
        /* top: 10vh; */
        right: 0;
    }
    .buttonFly > button{
        right: 5px;
    }
</style>