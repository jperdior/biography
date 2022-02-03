<template>
  <span>
    <b-button variant="primary" @click="showRegisterModal">{{
      labels.register
    }}</b-button>
    <b-modal :title="labels.register" ref="registerModal" :hide-footer="true">
      <register></register>
    </b-modal>
  </span>
</template>
<script>
import Register from "./Register.vue";
export default {
  name: "LoginModal",
  components: {
    Register,
  },
  computed: {
    labels() {
      return this.$store.getters["label/defaultLabels"];
    },
  },
  methods: {
    showRegisterModal() {
      this.$refs.registerModal.show();
    },
  },
};
</script>