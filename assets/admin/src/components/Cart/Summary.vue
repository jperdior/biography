<template>
  <b-container> </b-container>
</template>
<script>
export default {
  name: "Summary",
  props: {
    cart: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      cartItems: this.cart.items,
      cartTotal: this.cart.total,
    };
  },
  methods: {
    removeItem(item) {
      this.$store.dispatch("removeItem", item);
    },
  },
};
</script>