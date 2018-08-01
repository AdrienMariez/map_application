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
    destroyCategory(id){
        console.log("Category destruction done : "+ id);
    },
  }
  
  export default categoriesMethods