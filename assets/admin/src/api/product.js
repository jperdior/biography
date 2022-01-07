import axios from 'axios';

export default {

    getProducts: function () {
        return axios.get('/api/products');
    },
    getMaintenanceProduct: function () {
        return axios.get('/api/maintenance-product');
    },
    getEcommerceLabels: function () {
        return axios.get('/api/ecommerce/labels');
    },
    checkout: function (data) {
        return axios.post('/api/ecommerce/checkout', data);
    }
}