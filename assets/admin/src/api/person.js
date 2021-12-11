import axios from 'axios';


export default {
    createPerson: function (personData) {
        return axios.post('/api/people', personData);
    },
    getPerson: function (personId) {
        return axios.get(`/api/people/${personId}`);
    },
    updatePerson: function (personData) {
        return axios.put('/api/people/' + personData.id, personData);
    },
    getLabels: function () {
        return axios.get('/api/people/labels');
    }
};