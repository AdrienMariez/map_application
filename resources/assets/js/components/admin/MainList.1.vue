<template>
    <div>

        <v-expansion-panel
                    expand>
                    <!-- loop on categories -->
                    <v-expansion-panel-content
                    v-for="(category,i) in categories"
                    :key="i"
                    :value="showAllForms"
                    @click.stop="showAllForms = null">

                    <!-- header -->
                    <div 
                        slot="header">
                        <v-list class="noPaddingLeft">
                            <v-list-tile>
                                <v-list-tile-action>
                                    <!-- class="shadow" -->
                                    <v-icon
                                        large
                                        v-bind:style="{ color: category.color }">
                                        fa-{{category.icon}}
                                    </v-icon>
                                </v-list-tile-action>
                                <v-list-tile-action>
                                    <!-- loop on names in categories & translations -->
                                    <v-list-tile-content
                                        v-for="(catName,a) in categoriesNames"
                                        v-if="catName.fk_language_id == languageSelected && catName.fk_category_id == category.id"
                                        :key="a">
                                        {{catName.text}}
                                    </v-list-tile-content>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </div>

                    <!-- loop on references in categories -->
                    <v-list
                        class="pt-0 white"
                        v-for="(reference,y) in references"
                        v-if="reference.fk_category_id == category.id"
                        :key="y"
                        color="white">
                        <v-list-tile @click.stop="displayReferencePoints(reference.id, category.color)">
                            <v-list-tile-action>
                                <v-icon
                                    large
                                    v-bind:style="{ color: category.color }">
                                    fa-{{reference.icon}}
                                </v-icon>
                            </v-list-tile-action>
                            <v-list-tile-action>
                                <!-- loop on names in references & translations -->
                                <v-list-tile-content
                                    v-for="(refName,b) in referenceNames"
                                    v-if="refName.fk_language_id == languageSelected && refName.fk_reference_id == reference.id"
                                    :key="b">
                                    {{refName.fk_reference_id}} - 
                                    {{refName.text}}
                                </v-list-tile-content>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>

                    </v-expansion-panel-content>
        </v-expansion-panel>

    </div>

</template>

<script>
    //Needed for promises to work
        function Language({ id, name, code}) {
            this.id = id;
            this.name = name;
            this.code = code;
        }
        function Category({ id, icon, color, weight}) {
            this.id = id;
            this.icon = icon;
            this.color = color;
            this.weight = weight;
        }
        function CategoryName({ id, fk_category_id, fk_language_id, text}) {
            this.id = id;
            this.fk_category_id = fk_category_id;
            this.fk_language_id = fk_language_id;
            this.text = text;
        }
        function Reference({ id, icon, color, weight, fk_category_id}) {
            this.id = id;
            this.icon = icon;
            this.color = color;
            this.weight = weight;
            this.fk_category_id = fk_category_id;
        }
        function ReferenceName({ id, fk_reference_id, fk_language_id, text}) {
            this.id = id;
            this.fk_reference_id = fk_reference_id;
            this.fk_language_id = fk_language_id;
            this.text = text;
        }
        function Point({ id, link, icon, color, longitude, lattitude, uses_image, image_path}) {
            this.id = id;
            this.link = link;
            this.icon = icon;
            this.color = color;
            this.longitude = longitude;
            this.lattitude = lattitude;
            this.uses_image = uses_image;
            this.image_path = image_path;
        }
    //END Needed for promises to work

  export default {
    data () {
      return {
        drawer: true,
        mini: false,
        showAllForms: null,
        points: [],
        languages: [],
        languageSelected: 0,
        categories: [],
        categoriesNames: [],
        references: [],
        referenceNames: [],
        referenceDisplayed: [],
        working: false,
        actionSender: false,
      }
    },
    watch: {
        languages(val, oldVal){
            this.SetAdminLanguage();
        },
        languageSelected(val, oldVal) {
            this.languageSelected = val
            this.emitLanguage();
        }
    },
    methods: {
        //ON START FIND FRENCH LANGUAGE
            SetAdminLanguage() {

                var languageCode = window.navigator.userLanguage || window.navigator.language;
                // var languageCode = "de-AT";
                var language = languageCode.substring(0,2);
                var languages = JSON.parse(JSON.stringify(this.languages));
                var languageFrench = null;
                var languageBackup = null;

                languages.forEach(lang => {   
                        if (lang["code"] == "fr") {
                            languageFrench = lang["id"];
                        }
                        else{
                            languageBackup = lang["id"];
                        }
                });
                if (languageFrench == null) {
                        // if french isn't found, fall back to any other language last created.
                        languageFrench = languageBackup;
                }
                    
                this.languageSelected = languageFrench;
            },
        //POINTS CRUD READ
            readPoints() {
                this.mute = true;
                window.axios.get('/api/points').then(({ data }) => {
                data.forEach(point => {
                    //loops over each point in db
                    // console.log("point :");
                    // console.log(point);
                    this.points.push(new Point(point));
                });
                this.mute = false;
                });
            },
        //REFERENCES READ
            readReferences() {
                this.mute = true;
                window.axios.get('/api/references').then(({ data }) => {
                data.forEach(reference => {
                    //loops over each reference in db
                    // console.log("reference :");
                    // console.log(reference);
                    this.references.push(new Reference(reference));
                    // var obj = {};
                    // obj["id"] = reference.id;
                    // obj["isToBeDisplayed"] = false;
                    // obj["catColor"] = "";
                    // this.referenceDisplayed.push(obj);
                });
                this.mute = false;
                });
            },
        //REFERENCE NAMES READ
            readReferenceNames() {
                this.mute = true;
                window.axios.get('/api/referencesnames').then(({ data }) => {
                data.forEach(referenceName => {
                    //loops over each reference name in db
                    // console.log("reference name :");
                    // console.log(referenceName);
                    this.referenceNames.push(new ReferenceName(referenceName));
                });
                this.mute = false;
                });
            },
        //CATEGORIES READ
            readCategories() {
                this.mute = true;
                window.axios.get('/api/categories').then(({ data }) => {
                data.forEach(category => {
                    //loops over each category in db
                    // console.log("category :");
                    // console.log(category);
                    this.categories.push(new Category(category));
                });
                this.mute = false;
                });
            },
        //CATEGORIES NAMES READ
            readCategoriesNames() {
                this.mute = true;
                window.axios.get('/api/categoriesnames').then(({ data }) => {
                data.forEach(categoryName => {
                    //loops over each category name in db
                    // console.log("category name :");
                    // console.log(categoryName);
                    this.categoriesNames.push(new CategoryName(categoryName));
                    
                });
                this.mute = false;
                });
            },
        //LANGUAGES READ
            readLanguages() {
                this.mute = true;
                window.axios.get('/api/languages').then(({ data }) => {
                data.forEach(language => {
                    //loops over each language in db
                    // console.log("language :");
                    // console.log(language);
                    this.languages.push(new Language(language));
                    
                });
                this.mute = false;
                });
            },
    },
    created() {
        this.readReferenceNames();
        this.readPoints();
        this.readReferences();
        this.readCategories();
        this.readLanguages();
        this.readCategoriesNames();
    },
  }
</script>

<style scoped>