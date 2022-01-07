<template>
  <b-container>
    <b-row v-if="labels">
      <b-col md="4" offset-md="4" class="text-center">
        <h1>{{ labels.welcome }}</h1>
      </b-col>
    </b-row>
    <b-row>
      <login></login>
    </b-row>
  </b-container>
</template>
<script>
import Login from "../components/Login.vue";
export default {
  name: "Home",
  components: {
    Login,
  },
  mounted() {
    if (this.isAuthenticated) {
      this.$router.push("/dashboard");
    }
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"];
    },
  },
};
</script>
