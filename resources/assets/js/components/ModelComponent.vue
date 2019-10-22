<template>
  <v-app id="mainModelContainer">
    <models-menu
      id="modelsMenu">
    </models-menu>
    <model-container
      id="modelContainer1">
    </model-container>

    <!-- Contact form -->
    <contact-form
      class="buttonContact">
    </contact-form>

    <v-footer
      app
      text-xs-center
      align-center
      justify-center
      dark
      color="grey darken-3"
      id="footer"
      class="text-xs-center flexFooterPosition">
      <v-layout
        align-center
        row
        justify-start
        class="pl-3">
        <div class="hidden-xs-only">
          &copy; 2018 - {{new Date().getFullYear()}} - 
        </div>
        <a target="_blank" rel="noopener noreferrer" href="http://www.prayssac.fr/">Mairie de Prayssac</a>
      </v-layout>
    </v-footer>
  </v-app>
</template>

<script>
  import ModelContainer from "./models/ModelContainer.vue";
  import ModelsMenu from "./models/ModelsMenu.vue";
  import ContactForm from './user/ContactForm.vue'

  export default {
  components: {
    ModelContainer,
    ModelsMenu,
    ContactForm,
  }
};
</script>

<style scoped>
  a {
    color: rgb(146, 221, 123) !important;
    text-decoration: inherit;
  }
  #mainModelContainer {
    /* min-height: 100vh;
    max-width: 100%; */
    height: 100vh;
    width: 100vw;
    position: relative;
  }
  #modelsMenu {
    z-index: 50;
  }
  #modelContainer1 {
    z-index: 1;
    height: 98%;
    width: 98%;
    position: relative;
    left: 8%;
  }
  #footer {
    z-index: 25;
  }
  .flexFooterPosition {
    justify-content: center;
    /* if need to get it at start position : */
    /* justify-content: flex-start; */
  }
  .flexCenter {
    justify-content: center;
  }
</style>