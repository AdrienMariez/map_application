var contactsMethods = {
    readContacts() {
        var contacts = [];
        window.axios.get('/api/contact').then(({ data }) => {
            data.forEach(contact => {
                var date = new Date(contact.created_at);
                
                var dd = date.getDate();
                if(dd<10){
                    dd='0'+dd;
                } 
                var mm = date.getMonth()+1;
                if(mm<10){
                    mm='0'+mm;
                }
                var yyyy = date.getFullYear();
                var hh = date.getHours()+2;
                if(hh<10){
                    hh='0'+hh;
                }
                var mn = date.getMinutes();
                if(mn<10){
                    mn='0'+mn;
                }
                var ss = date.getSeconds();
                if(ss<10){
                    ss='0'+ss;
                }
                
                // var formattedTime = hh+':'+mn+':'+ss+' - '+dd+'/'+mm+'/'+yyyy;
                var formattedTime = dd+'/'+mm+'/'+yyyy+' - '+hh+':'+mn+':'+ss;
                var formattedTimeLong = 
                'Reçu le '+dd+'/'+mm+'/'+yyyy+' à '+hh+':'+mn+':'+ss;

                contact.created_at = formattedTime;
                contact.updated_at = formattedTimeLong;
                
                contacts.push(contact);
            });
        });
        return contacts;
    },
    destroyContact(id){
        axios.delete(`/api/contact/${id}`)
            .then(function (resp) {
            })
            .catch(function (error) {
                console.log(error.response.data);
                
                alert("Un problème est survenu lors de la suppression. Error located in contact.js !");
            });
    },
  }
  
  export default contactsMethods