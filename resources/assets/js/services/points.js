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
    //createPoint in EditPoint.vue
    // editPoint(id,newPoint) {
    //     axios.patch('/api/points/' + id, newPoint)
    //     .then(function (resp) {
    //     })
    //     .catch(function (error) {
    //         console.log(error.response.data);
            
    //         alert("Un problème est survenu lors de la mise à jour. Error located in EditPoint.vue !");
    //     });
    // },
    // createPointName(newPointName) {
    //     axios.post('/api/pointsnames', newPointName)
    //     .then(function (resp) {
    //     })
    //     .catch(function (error) {
    //         console.log(error.response.data);
            
    //         alert("Un problème est survenu lors de la création. Error located in EditPoint.vue !");
    //     });
    // },
    editPointName(id,newPointName) {
        axios.patch('/api/pointsnames/' + id, newPointName)
        .then(function (resp) {
        })
        .catch(function (error) {
            console.log(error.response.data);
            
            alert("Un problème est survenu lors de la mise à jour. Error located in EditPoint.vue !");
        });
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