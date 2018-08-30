<template>
    <router-view></router-view>
</template>

<script>
    export default {}
</script>

<style>
    .v-card{
        background-color: white !important;
    }
    .v-menu--inline{
        width: 100% !important;
    }
    .validationFailure{
        color: red;
    }
    .iconTooltip{
        cursor: help;
    }
    .v-btn.v-btn--disabled{
        background-color: #E0E0E0 !important;
        color: #757575 !important;
    }
</style>

