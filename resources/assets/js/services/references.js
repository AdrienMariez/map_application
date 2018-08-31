var referencesMethods = {
    readReferences() {
        var references = [];
        var x = true;
        var y = "test";
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
    readReferenceNamesFrOnly() {
        var referencesNames = [];
        window.axios.get('/api/referencesnames').then(({ data }) => {
            data.forEach(referenceName => {
                if (referenceName["fk_language_code"] == "fr") {
                    referencesNames.push(referenceName);
                }
            });
        });
        return referencesNames;
    },
    //createReference is in EditReference.vue
    // createReferenceName(newReferenceName) {
        // axios.post('/api/referencesnames', newReferenceName)
        //     .then(function (resp) {
        //     })
        //     .catch(function (error) {
        //         console.log(error.response.data);
                            
        //         alert("Un problème est survenu lors de la création. Error located in EditReference.vue !");
        //     });
    // },
    editReference(id, newReference) {
        axios.patch('/api/references/' + id, newReference)
            .then(function (resp) {
            })
            .catch(function (error) {
                console.log(error.response.data);
                
                alert("Un problème est survenu lors de la mise à jour. Error located in EditReference.vue !");
            });
    },
    // editReferenceName(id,newReferenceName) {
        // axios.patch('/api/referencesnames/' + id, newReferenceName)
        //     .then(function (resp) {
        //     })
        //     .catch(function (error) {
        //         console.log(error.response.data);
                            
        //         alert("Un problème est survenu lors de la mise à jour. Error located in EditReference.vue !");
        //     });
    // },
    destroyReference(id){
        axios.delete(`/api/references/${id}`)
            .then(function (resp) {
            })
            .catch(function (error) {
                console.log(error.response.data);
                
                alert("Un problème est survenu lors de la suppression. Error located in MainList.vue !");
            });
    },
    destroyReferenceName(id){
        axios.delete(`/api/referencesnames/${id}`)
            .then(function (resp) {
            })
            .catch(function (error) {
                console.log(error.response.data);
                
                alert("Un problème est survenu lors de la suppression. Error located in MainList.vue !");
            });
    },
  }
  
  export default referencesMethods