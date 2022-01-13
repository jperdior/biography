<template>
  <b-card
    :title="product.name"
    img-top
    img-src="https://picsum.photos/600/300/?image=25"
  >
    <b-card-text>
      {{ product.description }}
    </b-card-text>
    <b-badge variant="primary">{{ product.amount }} </b-badge>
    <b-form-group :label="labels.quantity" label-cols-sm="4">
      <b-input-group>
        <b-input-group-prepend>
          <b-button variant="link text-dark">
            <i class="fas fa-minus"></i>
          </b-button>
        </b-input-group-prepend>
        <b-form-input v-model="quantity" type="number" min="0"></b-form-input>
        <b-input-group-append>
          <b-button variant="link text-dark">
            <i class="fas fa-plus"></i>
          </b-button>
        </b-input-group-append>
      </b-input-group>
    </b-form-group>
  </b-card>
</template>
<script>
export default {
  name: "ProductMiniature",
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
  computed: {
    labels() {
      return this.$store.getters["label/productLabels"];
    },
  },
  data() {
    return {
      quantity: 0,
    };
  },
  watch: {
    quantity() {
      if (!this.$data.quantity) {
        return false;
      }
      let productData = {
        price: this.$props.product.idPrice,
        quantity: this.$data.quantity,
      };
      this.$emit("quantityUpdated", productData);
    },
  },
};
</script>