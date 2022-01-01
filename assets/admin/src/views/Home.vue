<template>
  <b-container>
    <b-row v-if="labels">
      <b-col>
        <b-img fluid src="/img/logo.png"></b-img>
        <h1>{{ labels.welcome }}</h1>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
export default {
  name: "Home",
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
