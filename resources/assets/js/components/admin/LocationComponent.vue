<template>
    <v-flex xs12 class="my-5">
        
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