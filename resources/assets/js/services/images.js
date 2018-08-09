var imagesMethods = {
    readImages() {
        var images = [];
        window.axios.get('/api/images').then(({ data }) => {
            data.forEach(image => {
                images.push(image);
            });
        });
        return images;
    },
    destroyImage(id){
        axios.delete(`/api/images/${id}`)
        .then(function (resp) {
        })
        .catch(function (error) {
            console.log(error.response.data);
            
            alert("Un problème est survenu lors de la suppression. Error located in ImageComponent.vue !");
        });
    },
  }
  
  export default imagesMethods