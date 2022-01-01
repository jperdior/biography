<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <galleries :person="person"></galleries>
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
};
</script>
