<template>
  <b-row>
    <b-col>
      <b-row
        v-for="(gallery, galleryIndex) in person.galleries"
        v-bind:key="galleryIndex"
      >
        <b-col cols="10">
          <h4>{{ gallery.title }}</h4>
          <b-col
            v-for="(image, imageIndex) in gallery.images"
            v-bind:key="image.id"
          >
            <b-img fluid :src="getImage(galleryIndex, imageIndex)"></b-img>
          </b-col>
        </b-col>
        <b-col>
          <gallery-uploader
            :gallery="gallery"
            :person="person"
          ></gallery-uploader>
          <gallery-remover
            v-if="gallery.id"
            @galleryRemoved="refreshPerson"
            :gallery="gallery"
          ></gallery-remover>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>
<script>
import ImageApi from "../../api/image.js";
import axios from "axios";
import Vue from "vue";
import GalleryUploader from "./GalleryUploader.vue";
import GalleryRemover from "./GalleryRemover.vue";
export default {
  name: "Galleries",
  components: {
    GalleryUploader,
    GalleryRemover,
  },
  props: {
    person: {
      type: Object,
      required: false,
      default: null,
    },
  },
  mounted() {
    this.$props.person.galleries.push({
      images: [],
    });
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
  },
  methods: {
    async imageUrl(file) {
      const response = await ImageApi.getImage(file.id);
      console.log(response);
      return response.data;
    },
    getImage(galleryIndex, imageIndex) {
      let record =
        this.$props.person.galleries[galleryIndex].images[imageIndex];
      if (!record.data) {
        Vue.set(record, "data", null);
        axios
          .get(
            `/security/images/${this.$props.person.galleries[galleryIndex].images[imageIndex].id}`
          )
          .then((result) => {
            Vue.set(record, "data", result.data);
          });
      }
      return record.data;
    },
    refreshPerson() {
      this.$store.dispatch("person/getPerson", this.$props.person.id);
    },
  },
};
</script>