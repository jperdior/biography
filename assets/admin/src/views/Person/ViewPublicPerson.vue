<template>
  <b-row no-gutters>
    <b-col>
      <person-viewer v-if="person" :person="person"></person-viewer>
    </b-col>
  </b-row>
</template>
<script>
import PersonViewer from "../../components/Person/Viewer/PersonViewer.vue";
export default {
  name: "ViewPublicPerson",
  components: {
    PersonViewer,
  },
  created() {
    this.$store.dispatch("person/getPerson", this.$route.params.id);
  },
  computed: {
    person() {
      return this.$store.getters["person/person"];
    },
  },
};
</script>