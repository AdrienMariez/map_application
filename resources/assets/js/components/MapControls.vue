<template>
    <div>
        <v-card-text class="buttonFly">
            <v-btn
                absolute
                dark
                fab
                center
                color="green lighten-1"
                v-bind:value=value
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
                v-bind:value=value
                v-on:click="zoomingOut($event.target.value)"
            >
                <v-icon>zoom_out</v-icon>
            </v-btn>
        </v-card-text>
    </div>
</template>

<script>

export default {
    props: ['value'],
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
        zoomingIn(value) {
            // var newValue = parseInt(value) + 1;
            //if input is changed, the value does not load properly...
            this.$emit('input', 1);
        },
        zoomingOut(value){
            // var newValue = parseInt(value) - 1;
            this.$emit('input', -1);
        }
    }
}
</script>

<style scoped>
    .buttonFly{
        height: 100px;
        width: 100px;
        /* top: 10vh; */
        right: 0;
    }
    .buttonFly > button{
        right: 5px;
    }
</style>