var referencesMethods = {
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
    destroyReference(id){
        console.log("Reference destruction done : "+ id);
    },
  }
  
  export default referencesMethods