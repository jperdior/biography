<template>
  <b-container>
    <b-row v-if="labels">
      <b-col>
        <maintenance-product
          v-if="maintenanceProduct"
          :product="maintenanceProduct"
        ></maintenance-product>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import Products from "../Product/Products.vue";
import ProductMiniature from "../Product/ProductMiniature.vue";
import MaintenanceProduct from "../Product/MaintenanceProduct.vue";
import ProductApi from "../../api/product.js";
export default {
  name: "StepFive",
  components: {
    Products,
    ProductMiniature,
    MaintenanceProduct,
  },
  created() {
    this.$store.dispatch("product/getMaintenanceProduct");
  },
  computed: {
    maintenanceProduct() {
      return this.$store.getters["product/maintenanceProduct"];
    },
    labels() {
      return this.$store.getters["label/productLabels"];
    },
  },
  data: function () {
    return {
      products: [],
    };
  },
  methods: {
    async checkout() {
      const response = await ProductApi.checkout(this.$data.products);
      window.location.href = response.data;
    },
  },
};
</script>