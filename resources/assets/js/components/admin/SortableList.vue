<template>
    <div>

    <!-- test cat -->
        <SortableList lockAxis="y" v-model="categoriesList">
            <SortableItem v-for="(category, i) in categoriesList" :index="i" :key="i" :item="category"/>
        </SortableList>
        
    <!-- test ref -->

        <!-- <v-list two-line>
            <template v-for="(cat,i) in categories">
                <v-list-tile :key="i">
                    <v-icon v-bind:style="{ color: cat.color }">
                        {{cat.icon}}
                    </v-icon>
                    {{cat.text}}
                </v-list-tile>
            </template>
        </v-list> -->

        <!-- <SortableList lockAxis="y" v-model="referencesList">
            <SortableItem v-for="(ref, y) in referencesList" :index="y" :key="y" :item="ref"/>
        </SortableList> -->
    <!-- Save button -->
        <v-list>
            <v-btn
                color="success"
                @click="save()">
                <!-- editCategory is used as the result is exactly the same. -->
                <v-icon>check_circle_outline</v-icon> Sauvegarder
            </v-btn> 
        </v-list>
    </div>

</template>

<script>
    import categoriesMethods from './../../services/categories.js'
    import referencesMethods from './../../services/references.js'

    import { ContainerMixin, ElementMixin } from 'vue-slicksort';
    const SortableList = {
        mixins: [ContainerMixin],
        template: `
        <ul class="list">
            <slot />
        </ul>
        `,
    };

    const SortableItem = {
        mixins: [ElementMixin],
        props: ['item'],
        template: `
        <li class="list-item">
            <v-icon v-bind:style="{ color: item.color }">
                {{item.icon}}
            </v-icon>
            {{item.text}}
        </li>
        `,
    };

  export default {
    components: {
        SortableItem,
        SortableList,
    },
    data () {
      return {
        languageSelected: 'fr',
        categories: [],
        categoriesNames: [],
        references: [],
        referenceNames: [],

        categoriesList: [],
        referencesList: [],
      }
    },
    watch: {
        referenceNames(val, oldVal){
            if (val.length > 0) {
                this.pageInit();
            }
        },
    },
    methods: {
        pageInit(){
                // var categoriesNames = JSON.parse(JSON.stringify(this.categoriesNames));
                // console.log(categoriesNames);
            // Populate categoriesList
                this.categories.forEach(category => {
                    this.categoriesList.push(category);
                });
                for (let cat = 0; cat < this.categories.length; cat++) {

                    for (let catName = 0; catName < this.categoriesNames.length; catName++) {
                        
                        if (this.categoriesNames[catName]["fk_language_code"] == this.languageSelected && this.categoriesNames[catName]["fk_category_id"] == this.categories[cat]["id"]) {

                            this.categoriesList[cat]["text"] = this.categoriesNames[catName]["text"];
                            break;

                        }
                    }
                }
            // Populate referencesList
                // for (let i = 0; i < this.categories.length; i++) {
                //     for (let y = 0; y < this.references.length; y++) {
                //         if (this.categories[i]["id"] === this.references[y]["fk_category_id"]) {
                //             this.referencesList.push(this.categories[i]["id"]);
                //             // this.referencesList[this.categories[i]["id"]].push(reference);
                //         }
                //     }
                // }
                // this.references.forEach(reference => {
                //     console.log(reference["fk_category_id"]);
                //     this.referencesList.push(reference);
                // });
                // for (let ref = 0; ref < this.references.length; ref++) {

                //     for (let refName = 0; refName < this.referenceNames.length; refName++) {
                        
                //         if (this.referenceNames[refName]["fk_language_code"] == this.languageSelected && this.referenceNames[refName]["fk_category_id"] == this.references[ref]["id"]) {

                //             this.referencesList[ref]["text"] = this.referenceNames[refName]["text"];
                //             break;

                //         }
                //     }
                // }
        },

        save() {
            // var categoriesList = JSON.parse(JSON.stringify(this.categoriesList));
            // console.log(categoriesList);
            var referencesList = JSON.parse(JSON.stringify(this.referencesList));
            console.log(referencesList);
        },
        //API CALLS
            methodsApiCalls() {
                this.categories = categoriesMethods.readCategories();
                this.categoriesNames = categoriesMethods.readCategoriesNames();
                this.references = referencesMethods.readReferences();
                this.referenceNames = referencesMethods.readReferenceNames();
            },
    },
    created() {
        this.methodsApiCalls();
    },
  }
</script>

<style scoped>