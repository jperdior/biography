<template>
  <b-row>
    <b-col>
      <b-row>
        <b-col>
          <p>
            {{ labels.maintenance_explanation }}
          </p>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-row>
            <b-col>
              <b-button @click="checkout">{{ labels.checkout }}</b-button>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>
<script>
import ProductApi from "../../api/product.js";
export default {
  name: "MaintenanceProduct",
  props: {
    product: {
      type: Object,
      required: true,
      default: null,
    },
  },
  computed: {
    maintenanceProduct() {
      return this.$store.getters["product/maintenanceProduct"];
    },
    labels() {
      return this.$store.getters["product/productLabels"];
    },
  },
  methods: {
    async checkout() {
      const response = await ProductApi.checkout([]);
      console.log(response);
      window.location.href = response.data;
    },
  },
};
</script>