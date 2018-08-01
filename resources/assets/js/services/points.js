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
        console.log("Point destruction done : "+ id);
    },
  }
  
  export default pointsMethods