<template>
  <span>
    <b-button variant="primary" @click="showLoginModal">{{
      labels.login
    }}</b-button>
    <b-modal :title="labels.login" ref="loginModal" :hide-footer="true">
      <login></login>
    </b-modal>
  </span>
</template>
<script>
import Login from "./Login.vue";
export default {
  name: "LoginModal",
  components: {
    Login,
  },
  computed: {
    labels() {
      return this.$store.getters["label/defaultLabels"];
    },
  },
  methods: {
    showLoginModal() {
      this.$refs.loginModal.show();
    },
  },
};
</script>