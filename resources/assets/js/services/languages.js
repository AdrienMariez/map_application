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
    readActiveLanguages() {
        var languages = [];
        window.axios.get('/api/languages').then(({ data }) => {
            data.forEach(language => {
                if (language.active == 1) {
                    languages.push(language);
                }
            });
        });
        return languages;
    },
  }
  
  export default languagesMethods