var pointsMethods = {
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
    destroyPoint(id){
        axios.delete(`/api/points/${id}`)
            .then(function (resp) {
            })
            .catch(function (error) {
                console.log(error.response.data);
                
                alert("Un problème est survenu lors de la suppression. Error located in MainList.vue !");
            });
    },
    destroyPointName(id){
        axios.delete(`/api/pointsnames/${id}`)
            .then(function (resp) {
            })
            .catch(function (error) {
                console.log(error.response.data);
                
                alert("Un problème est survenu lors de la suppression. Error located in MainList.vue !");
            });
    },
  }
  
  export default pointsMethods