<template>
    <v-flex xs12 class="my-5">
        <location-map-admin
            v-bind:localLattitude="localLattitude"
            v-bind:localLongitude="localLongitude"
            @pointLattitudeUpdate="pointLattitudeUpdate"
            @pointLongitudeUpdate="pointLongitudeUpdate">
        </location-map-admin>
        <v-flex xs12 class="my-5">
            <div>Lattitude :</div>
            <v-text-field
                v-model="localLattitude"
                :rules="lattitudeRules"
                placeholder="44.5020"
                single-line
                :mask="mask"
                required>
            </v-text-field>
            <div>Longitude :</div>
            <v-text-field
                v-model="localLongitude"
                :rules="longitudeRules"
                placeholder="01.1980"
                single-line
                :mask="mask"
                required>
            </v-text-field>
        </v-flex>
    </v-flex>
</template>

<script>

    import LocationMapAdmin from "./LocationMapAdmin.vue";

    export default {
        props: ['lattitude', 'longitude'],
        data () {
            return {
                localLattitude: null,
                localLongitude: null,
                mask: '##.####',
                lattitudeRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length >= 6) || "exemple : 44.5020"
                ],
                longitudeRules: [
                    v => !!v || "Invalide ! ",
                    v => (v && v.length >= 6) || "exemple : 01.1980"
                ],
            }
        },
        watch: {
            lattitude(val, oldVal){
                this.localLattitude = val;
            },
            longitude(val, oldVal){
                this.localLongitude = val;
            },
            //map limits :
                // 1.027538         1.360224
                // 44.392567        44.590387

                // 10275            13602
                // 443925           445903
            //
            localLattitude(val, oldVal){
                if (isNaN(val)) {
                    this.localLattitude = oldVal;
                }
                this.$emit('pointLattitudeUpdate', this.localLattitude);
            },
            localLongitude(val, oldVal){
                if (isNaN(val)) {
                    this.localLongitude = oldVal;
                }
                this.$emit('pointLongitudeUpdate', this.localLongitude);
            },
        },
        methods: {
            pointLattitudeUpdate() {
            },
            pointLongitudeUpdate() {
            },
        },
        created() {
        },
        components: {
            LocationMapAdmin
        }
    }
</script>

<style scoped>