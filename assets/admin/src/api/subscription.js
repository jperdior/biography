import axios from 'axios';

export default {

    getSubscription: function () {
        return axios.get('/api/subscription');
    },
}