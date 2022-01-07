<template>
  <b-row>
    <b-col
      cols="12"
      md="6"
      lg="4"
      v-for="product in products"
      v-bind:key="product.id"
    >
      <product-miniature
        @quantityUpdated="quantityUpdatedEvent"
        :product="product"
      ></product-miniature>
    </b-col>
  </b-row>
</template>
<script>
import ProductMiniature from "./ProductMiniature.vue";
export default {
  name: "Products",
  components: {
    ProductMiniature,
  },
  async mounted() {
    await this.$store.dispatch("product/getProducts");
  },
  data() {
    return {
      productsSelected: [],
    };
  },
  computed: {
    products() {
      return this.$store.getters["product/products"];
    },
  },
  methods: {
    quantityUpdatedEvent(productData) {
      for (let i = 0; i < this.productsSelected.length; i++) {
        if (this.productsSelected[i].price === productData.price) {
          if (productData.quantity === 0) {
            this.productsSelected.splice(i, 1);
          } else {
            this.productsSelected[i].quantity = productData.quantity;
          }
          return;
        }
      }
      if (productData.quantity > 0) {
        this.productsSelected.push(productData);
      }
      this.$emit("productsUpdated", this.productsSelected);
    },
  },
};
</script>