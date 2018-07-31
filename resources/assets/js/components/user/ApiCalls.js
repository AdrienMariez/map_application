var methods = {
    readReferences() {
        var references = [];
        window.axios.get('/api/references').then(({ data }) => {
            data.forEach(reference => {
                
                references.push(reference);
            });
        });
        return references;
    },
  }
  
  export default methods