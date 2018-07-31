<template>
    <div>
        <div v-if="page == 'reference'">
            Can edit existing reference here
        </div>
        <div v-if="page == 'referenceParent'">
            Can create new reference here under parent
        </div>
    </div>

</template>

<script>
  export default {
    props: ['idSelected', 'page'],
    data () {
      return {
      }
    },
    watch: {
        idSelected(val, oldVal){
            console.log("id changed in reference THIS IS NOT SUPPOSED TO HAPPEN.");console.log("Previous value : "+val+" New value : "+oldVal);
        }
    },
    methods: {
        
        //POINTS CRUD NEED READ ONLY
            // TO REMOVE
            //methods other than read() are useless, but kept for the moment until I can remove them and not break anything in the process.
            create() {
                this.mute = true;
                
                window.axios.get('/api/points/create').then(({ data }) => {
                this.points.push(new Point(data));
                this.mute = false;
                });
                window.axios.get('/api/languages/create').then(({ data }) => {
                this.languages.push(new Language(data));
                this.mute = false;
                });
                window.axios.get('/api/categories/create').then(({ data }) => {
                this.categories.push(new Category(data));
                this.mute = false;
                });
                window.axios.get('/api/references/create').then(({ data }) => {
                this.references.push(new Reference(data));
                this.mute = false;
                });
            },
            readPoints() {
                console.log("value of id :");
                
                console.log(this.idSelected);
                
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
            update(id, color) {
                this.mute = true;
                window.axios.put(`/api/points/${id}`, { color }).then(() => {
                this.points.find(point => point.id === id).color = color;
                this.mute = false;
                });
            },
            del(id) {
                this.mute = true;
                window.axios.delete(`/api/points/${id}`).then(() => {
                let index = this.points.findIndex(point => point.id === id);
                this.points.splice(index, 1);
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
        //each line calls for the function responsible for the api returns
        this.readReferenceNames();
        this.readPoints();
        this.readReferences();
        this.readCategories();
        this.readLanguages();
        this.readCategoriesNames();
    }
  }

</script>

<style scoped>