<template>
  <b-row>
    <b-col>
      <b-row>
        <b-col>
          <gallery-uploader :person="person"></gallery-uploader>
        </b-col>
      </b-row>
      <b-row>
        <b-col
          md="4"
          v-for="(gallery, galleryIndex) in person.galleries"
          v-bind:key="galleryIndex"
        >
          <b-row>
            <b-col>
              <h4>{{ gallery.title }}</h4>
              <carousel :margin="10" :nav="false" :dots="false">
                <b-img
                  v-for="image in gallery.images"
                  v-bind:key="image.id"
                  fluid
                  :src="image.filePathBase64"
                ></b-img>
              </carousel>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <gallery-uploader
                @galleryUpdated="refreshPerson"
                :gallery="gallery"
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
    </b-col>
  </b-row>
</template>
<script>
import axios from "axios";
import Vue from "vue";
import GalleryUploader from "./GalleryUploader.vue";
import GalleryRemover from "./GalleryRemover.vue";
import carousel from "vue-owl-carousel";
export default {
  name: "Galleries",
  components: {
    GalleryUploader,
    GalleryRemover,
    carousel,
  },
  props: {
    person: {
      type: Object,
      required: false,
      default: null,
    },
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
  },
  methods: {
    refreshPerson() {
      this.$store.dispatch("person/getPerson", this.$props.person.id);
    },
  },
};
</script>