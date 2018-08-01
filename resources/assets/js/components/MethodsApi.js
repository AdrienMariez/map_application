var methods = {
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
    readReferences() {
        var references = [];
        window.axios.get('/api/references').then(({ data }) => {
            data.forEach(reference => {
                references.push(reference);
            });
        });
        return references;
    },
    readReferenceNames() {
        var referencesNames = [];
        window.axios.get('/api/referencesnames').then(({ data }) => {
            data.forEach(referenceName => {
                referencesNames.push(referenceName);
            });
        });
        return referencesNames;
    },
    readPoints() {
        var points = [];
        window.axios.get('/api/points').then(({ data }) => {
            data.forEach(point => {
                points.push(point);
            });
        });
        return points;
    },
    readPointsPopupContent() {
        var pointsnames = [];   
        window.axios.get('/api/pointsnames').then(({ data }) => {
            data.forEach(pointContent => {
                pointsnames.push(pointContent);
            });
        });
        return pointsnames;
    },
    readLanguages() {
        var languages = [];
        window.axios.get('/api/languages').then(({ data }) => {
            data.forEach(language => {
                languages.push(language);
            });
        });
        return languages;
    },
  }
  
  export default methods