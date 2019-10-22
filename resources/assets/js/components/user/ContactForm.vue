<template>
    <v-layout row justify-left>
        <v-dialog v-model="dialog" persistent max-width="500px" transition="dialog-bottom-transition">
            <v-btn
                slot="activator"
                @click="validStart"
                absolute
                dark
                center
                color="green lighten-1">
                <div class="linkColor">{{ $t("message.info") }}</div>
            </v-btn>
            <v-card>
                <v-card-title>
                    <v-layout wrap justify-space-between>
                        <v-flex xs6 align-left>
                            <span class="headline text-xs-left">{{ $t("message.info_legal") }}</span>
                        </v-flex>
                        <v-flex xs2 align-right>
                            <v-list-tile
                                @click.native="dialog = false"  
                                @click="clear"
                                class="text-xs-right"
                                >
                                <v-list-tile-action class="cursorAction">
                                    <v-icon>close</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-flex>
                    </v-layout>
                </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <span>{{ $t("message.info_desc_1") }}</span>
                                </v-flex>
                                <v-flex xs12>
                                    <span>{{ $t("message.info_desc_2") }}</span>
                                </v-flex>
                                <v-flex xs12>
                                    <small>{{ $t("message.info_dev_1") }}</small>
                                </v-flex>
                                <v-flex xs12>
                                    <small>
                                        <a href="https://github.com/AdrienMariez/map_application" target="_blank">
                                            {{ $t("message.info_dev_2") }}
                                        </a>
                                    </small>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        data () {
            return {
                dialog: false,
            }
        },
        methods: {
        }
    }
</script>

<style scoped>
    .buttonContact{
        height: 45px;
        width: 100px;
        position: absolute;
        right: 20px;
        bottom: 0px;
        z-index: 30;
    }
    .buttonContact > button{
        right: 5px;
    }
    .linkColor{
        color: rgb(245, 255, 153);
    }
    .logoContainerMini{
        height: 100%;
    }
    .logoContainerMini > img{
        width: 48px;
        height: 48px;
    }
    .cursorAction{
        cursor: pointer;
    }
    a{
        color: rgb(146, 221, 123) !important;
        text-decoration: inherit;
    }
</style>