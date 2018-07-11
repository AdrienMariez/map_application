<template>
        <v-expansion-panel
            expand>
            <!-- loop on categories -->
            <v-expansion-panel-content
                color="green darken-3"
                class="green darken-3">

                <!-- header -->
                <div 
                    slot="header">
                    <v-list class="noPaddingLeft">
                        <v-list-tile>
                            <v-list-tile-action>
                                <v-icon large color="brown lighten-4">
                                    home
                                </v-icon>
                            </v-list-tile-action>
                            <v-list-tile-action>
                                <v-list-tile-content v-if="fr">
                                    Categorie
                                </v-list-tile-content>
                                <v-list-tile-content v-if="!fr">
                                    Category
                                </v-list-tile-content>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                </div>

                <!-- loop on references in categories -->
                <v-list
                    class="pt-0">
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-icon color="blue darken-2">
                                grade
                            </v-icon>
                        </v-list-tile-action>
                        <v-list-tile-action>
                            <v-list-tile-content v-if="fr">
                                {{ link }}
                            </v-list-tile-content>
                            <v-list-tile-content v-if="!fr">
                                {{ link }}
                            </v-list-tile-content>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>

            </v-expansion-panel-content>
        </v-expansion-panel>


    <!-- <div class="point">
        <div class="col-1"> -->
            <!-- <img :src="image"/> -->
        <!-- </div>
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
            <div>image path: {{ image_path }}</div> -->
            <!-- <button @click="del">Delete</button> -->
        <!-- </div>
    </div> -->

</template>

<script>
  export default {
    data () {
      return {
        // fr: true,
      }
    },
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
    props: ['id', 'link', 'icon', 'color', 'longitude', 'lattitude', 'uses_image', 'image_path', 'fr']
    // filters: {
    //   properCase(string) {
    //     return string.charAt(0).toUpperCase() + string.slice(1);
    //   }
    // }
  }
</script>
<style>
    /* .point {
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
    } */
</style>
