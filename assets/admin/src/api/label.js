import axios from "axios";

export default {
    getPersonLabels: function () {
        return axios.get('/api/label/persons');
    },
    getProductLabels: function () {
        return axios.get('/api/label/products');
    },
    getDefaultLabels: function () {
        return axios.get('/api/label/default');
    },
    getNoteLabels: function () {
        return axios.get('/api/label/notes');
    }
}