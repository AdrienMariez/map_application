var languagesMethods = {
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
  
  export default languagesMethods