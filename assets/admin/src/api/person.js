import axios from 'axios';


export default {
    getPersons: function () {
        return axios.get('/api/people');
    },
    getPersonNeedsLogin: function (id) {
        return axios.get('/api/people/' + id + '/needslogin');
    },
    getMainPerson: function () {
        return axios.get('/api/people/main');
    },
    createPerson: function (personData) {
        return axios.post('/api/people', personData);
    },
    getPerson: function (personId) {
        return axios.get(`/api/people/${personId}`);
    },
    updatePerson: function (personData) {
        return axios.put('/api/people/' + personData.id, personData);
    },
    uploadPersonMainPicture: function (personId, personData) {
        return axios.post('/api/image/' + personId + '/person', personData);
    },
    getPersonMainPicture: function (personId) {
        return axios.get('/api/image/' + personId + '/person');
    },
    uploadFamiliarMainPicture: function (familiarId, familiarData) {
        return axios.post('/api/image/' + familiarId + '/familiar', familiarData);
    },
    getFamiliarMainPicture: function (familiarId) {
        return axios.get('/api/image/' + familiarId + '/familiar');
    }
};