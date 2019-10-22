<template>
  <v-card dark tile flat>
    <model-obj
      class="modelContainerCanvas"
      :backgroundColor="bgColor"
      :rotation="rotation"
      @on-load="onLoad"
      src="static/models/obj/prayssac/prayssac.obj"
      mtl="static/models/obj/prayssac/prayssac.mtl">
    </model-obj>
  </v-card>
</template>

<script>
    import { ModelObj } from 'vue-3d-model'

    export default {
      data() {
        return {
          bgColor: '#FFFFFF',
          rotation: {
            x: -Math.PI / 2,
            y: 0,
            z: 0
          }
        };
      },
      methods: {
        onLoad () {
          this.rotate();
        },
        rotate () {
          this.rotation.z += 0.0005;
          requestAnimationFrame( this.rotate );
        }
      },
      components: {
        ModelObj
      }
    }
</script>

<style scoped>
    #modelContainerCanvas{
    /* left as comment to remember NOT to try to use it */
    /* position: initial !important; */
    /* height: 100%;
    width: 100%; */
    z-index: 1;
  }
</style>