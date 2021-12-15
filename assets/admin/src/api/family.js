import axios from 'axios';


export default {
    getFamilies: function () {
        return axios.get('/api/families');
    },
    createFamily: function (familyData) {
        return axios.post('/api/families', familyData);
    },
    getFamily: function (id) {
        return axios.get('/api/families/' + id);
    }
}