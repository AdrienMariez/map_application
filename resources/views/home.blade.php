<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- <title>{{ config('app.name', 'Carte de Prayssac') }}</title> -->
        <title>Prayssac carte</title>
        <!-- Material Icons -->
            <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
        <!-- Font Awesome -->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
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
        <!-- geoportail -->
            <!-- <script src="../../node_modules/geoportal-extensions-leaflet/dist/GpPluginLeaflet.js" data-key="CLEAPI"></script> -->
        <!-- Leaflet ExtraMarkers -->
            <!-- https://github.com/coryasilva/Leaflet.ExtraMarkers -->
            <link rel="stylesheet" href="css/leaflet.extra-markers.min.css">
            <script src="js/leaflet.extra-markers.min.js"></script>
    </head>
    <body>
        
        <div id="app">
            <home title="{{ config('app.name', 'Carte de Prayssac') }}" :items="routes">
                <router-view></router-view>
            </home>
        </div>
        
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>