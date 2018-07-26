<template>
    <div class="point">
        <!-- <div class="col-2">
            <h3>link: {{ link }}</h3>
            <div>icon: {{ icon }}</div>
            <select @change="update">
                <option
                v-for="col in [ 'red', 'green' ]"
                :value="col"
                :key="col"
                :selected="col === color ? 'selected' : ''"
                >{{ col }}</option>
            </select>
            <div>longitude: {{ longitude }}</div>
            <div>lattitude: {{ lattitude }}</div>
            <div>uses image: {{ uses_image }}</div>
            <div>image path: {{ image_path }}</div> -->
            <!-- <button @click="del">Delete</button> -->
        <!-- </div> -->
    </div>
</template>
<script>
  export default {
    methods: {
      update(val) {
        this.$emit('update', this.id, val.target.selectedOptions[0].value);
      },
      del() {
        this.$emit('delete', this.id);
      }
    },
    mounted() {
        // var point = [this.id, this.link, this.icon, this.color, this.longitude, this.lattitude, this.uses_image, this.image_path]
        // console.log("Pointdisplay whoosh");
        // this.$emit('displayPoints', point);
    },
    props: ['id', 'link', 'icon', 'color', 'longitude', 'lattitude', 'uses_image', 'image_path']
  }
</script>

<style>
</style>
