<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <create-family></create-family>
      </b-col>
    </b-row>
    <b-table :items="families"> </b-table>
  </b-container>
</template>
<script>
import CreateFamily from "../../components/Family/CreateFamily.vue";
export default {
  name: "FamilyList",
  components: {
    CreateFamily,
  },
  mounted() {
    this.$store.dispatch("family/getFamilies");
  },
  computed: {
    families() {
      return this.$store.getters["family/families"];
    },
  },
};
</script>