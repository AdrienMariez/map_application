<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Prayssac carte</title>

    <!-- Styles & scripts -->
        <!-- Bootstrap -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Material Icons -->
            <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
        <!-- Font Awesome -->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <!-- Material Design -->
            <!-- <link href="css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" /> -->
        <!-- Vuetify -->
            <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
        <!-- Leaflet -->
            <link
            rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
            integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
            crossorigin=""/>
            <script
            src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin="">
            </script>
        <!-- i18n translation -->
            <!-- <script src="https://unpkg.com/vue-i18n/dist/vue-i18n.js"></script> -->
        <!-- geoportail -->
            <!-- <script src="../../node_modules/geoportal-extensions-leaflet/dist/GpPluginLeaflet.js" data-key="CLEAPI"></script> -->
        <!-- Leaflet ExtraMarkers -->
            <!-- https://github.com/coryasilva/Leaflet.ExtraMarkers -->
            <link rel="stylesheet" href="css/leaflet.extra-markers.min.css">
            <script src="js/leaflet.extra-markers.min.js"></script>
    <!-- END Styles & scripts -->
</head>
<body>
    <div id="app">
        <app-component></app-component>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
</body>
</html>
