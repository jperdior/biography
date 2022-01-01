import axios from 'axios';

export default {

    createChild(personId) {
        return axios.post('/api/children/' + personId);
    },
    deleteChild(childId) {
        return axios.delete('/api/child/' + childId);
    }

}