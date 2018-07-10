<template>
    <div class="point">
        <div class="col-1">
            <!-- <img :src="image"/> -->
        </div>
        <div class="col-2">
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
            <div>image path: {{ image_path }}</div>
            <button @click="del">Delete</button>
        </div>
    </div>
</template>
<script>
  export default {
    computed: {
    //   image() {
    //     return `/images/${this.color}.png`;
    //   }
    },
    methods: {
      update(val) {
        this.$emit('update', this.id, val.target.selectedOptions[0].value);
      },
      del() {
        this.$emit('delete', this.id);
      }
    },
    props: ['id', 'link', 'icon', 'color', 'longitude', 'lattitude', 'uses_image', 'image_path']
    // filters: {
    //   properCase(string) {
    //     return string.charAt(0).toUpperCase() + string.slice(1);
    //   }
    // }
  }
</script>
<style>
    .point {
        display: flex;
        margin: 1em 1em 1em 0;
        border: 1px solid #d1d1d1;
        padding: 1em;
        max-width: 350px;
        background-color: white;
    }

    .col-2 {
        margin-left: 1em;
    }

    .col-2 > h3 {
        margin: 0.5em 0;
    }
</style>
