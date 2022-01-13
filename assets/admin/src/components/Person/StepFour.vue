<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <galleries :person="person"></galleries>
      </b-col>
    </b-row>
    <hr />
    <b-row>
      <b-col>
        <b-button v-if="person" @click="submitPerson()">
          {{ defaultLabels.save_and_continue }}
        </b-button>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import Galleries from "./Gallery/Galleries.vue";
export default {
  name: "StepFour",
  components: {
    Galleries,
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
      return this.$store.getters["label/personLabels"];
    },
    defaultLabels() {
      return this.$store.getters["label/defaultLabels"];
    },
  },
  methods: {
    submitPerson() {
      this.$emit("next");
    },
  },
};
</script>
