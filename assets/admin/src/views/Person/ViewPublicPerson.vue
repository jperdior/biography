<template>
  <b-container>
    <person-viewer :person="person"></person-viewer>
  </b-container>
</template>
<script>
import PersonViewer from "../../components/Person/PersonViewer.vue";
export default {
  name: "ViewPublicPerson",
  components: {
    PersonViewer,
  },
  mounted() {
    this.$store.dispatch("person/getPerson", this.$route.params.id);
  },
  computed: {
    person() {
      return this.$store.getters["person/person"];
    },
  },
};
</script>