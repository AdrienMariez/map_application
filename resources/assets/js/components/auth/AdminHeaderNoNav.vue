<template>
    <div>
        <!-- top header -->
        <v-card
            xs12>
            <v-layout row justify-space-around>
                <v-flex xs12 sm10>
                    <v-card-title>
                        <v-layout row>
                            <v-flex>
                                <v-layout
                                    align-center
                                    row
                                    class="logoContainerTopNav">
                                    <img
                                        color="transparent"
                                        class="logoMini transparent hidden-md-and-up" :src="'/images/Prayssac_logo.png'" >
                                    <img
                                        color="transparent"
                                        class="logoMedium transparent hidden-sm-and-down" :src="'/images/Prayssac_logo.png'" >
                                    <v-toolbar-title
                                        class="hidden-xs-only">
                                        Menu d'administration de la carte
                                    </v-toolbar-title>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-card-title>
                </v-flex>
            </v-layout>
        </v-card>
    </div>

</template>

<script>

  export default {
    data () {
      return {
      }
    },
  }
</script>

<style scoped>
    .v-card__title{
       padding: 0; 
    }
    .logoContainerTopNav{
        height: 100%;
        flex-direction: column;
    }
    .logoMini{
        width: 48px;
        height: 48px;
    }
    .logoMedium{
        width: 100px;
        height: 100px;
    }
    /* .white--text{
        text-shadow: 2px 2px 8px #000000;
    } */
</style>