var categoriesMethods = {
    readCategories() {
        var categories = [];
        window.axios.get('/api/categories').then(({ data }) => {
            data.forEach(category => {
                categories.push(category);
            });
        });
        return categories;
    },
    readCategoriesNames() {
        var categoriesnames = [];
        window.axios.get('/api/categoriesnames').then(({ data }) => {
            data.forEach(categoryName => {
                categoriesnames.push(categoryName);
            });
        });
        return categoriesnames;
    },
    readCategoriesNamesFrOnly() {
        var categoriesnames = [];
        window.axios.get('/api/categoriesnames').then(({ data }) => {
            data.forEach(categoryName => {
                if (categoryName["fk_language_code"] == "fr") {
                    categoriesnames.push(categoryName);
                }
            });
        });
        return categoriesnames;
    },
    destroyCategory(id){
        axios.delete(`/api/categories/${id}`)
            .then(function (resp) {
            })
            .catch(function (error) {
                console.log(error.response.data);
                
                alert("Un problème est survenu lors de la suppression. Error located in MainList.vue !");
            });
    },
    destroyCategoryName(id){
        axios.delete(`/api/categoriesnames/${id}`)
            .then(function (resp) {
            })
            .catch(function (error) {
                console.log(error.response.data);
                
                alert("Un problème est survenu lors de la suppression. Error located in MainList.vue !");
            });
    },
  }
  
  export default categoriesMethods