import axios from "axios";

export default {

    createGallery: function (galleryData) {
        return axios.post('/api/galleries', galleryData);
    },
    updateGallery: function (galleryData) {
        return axios.post(`/api/galleries`, galleryData);
    },
    deleteGallery: function (galleryId) {
        return axios.delete(`/api/galleries/${galleryId}`);
    }

}