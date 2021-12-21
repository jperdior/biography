import axios from "axios";

export default {

    getImage: function (imageId) {
        return axios.get(`/security/images/${imageId}`);
    }
}