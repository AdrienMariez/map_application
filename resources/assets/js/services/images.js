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
        console.log("Image destruction done : "+ id);
    },
  }
  
  export default imagesMethods