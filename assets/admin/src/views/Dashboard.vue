<template>
  <b-container>
    <b-row>
      <b-col>
        <h1>{{ labels.welcome }}</h1>
      </b-col>
    </b-row>

    <b-row v-if="!mainPerson">
      <b-col>
        <p>
          {{ labels.no_persons }}
        </p>
        <b-button variant="primary" :to="{ name: 'CreatePerson' }">{{
          labels.create_person
        }}</b-button>
      </b-col>
    </b-row>

    <b-row v-else>
      <b-button
        variant="success"
        :to="{ name: 'EditPerson', params: { id: mainPerson.id } }"
        >{{ labels.edit_person }}</b-button
      >
      <b-button
        variant="info"
        :to="{ name: 'Person', params: { id: mainPerson.id } }"
      >
        {{ labels.view_person }}
      </b-button>
    </b-row>
    <b-row v-if="subscription">
      <b-col>
        <b-row>
          <b-col>
            <p>
              {{ labels.subscription_active_until }}
              {{ subscriptionExpirationDate }}
            </p>
          </b-col>
        </b-row>
        <b-row>
          <b-col>
            <p>
              {{ labels.extra_products_explanation }}
            </p>
          </b-col>
        </b-row>
        <plate :person="mainPerson"></plate>
        <b-row>
          <b-col>
            <products @productsUpdated="productsUpdatedEvent"> </products>
          </b-col>
        </b-row>
        <b-row>
          <b-col>
            <b-button @click="checkout">{{ productLabels.checkout }}</b-button>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
    <b-row v-else>
      <b-col>
        <p>{{ labels.subscription_inactive }}</p>
        <p>{{ labels.data_will_be_deleted }} {{ personDeletionDate }}</p>
        <maintenance-product
          v-if="maintenanceProduct"
          :product="maintenanceProduct"
        ></maintenance-product>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import moment from "moment";
import Plate from "../components/Person/Plate.vue";
import MaintenanceProduct from "../components/Product/MaintenanceProduct.vue";
import Products from "../components/Product/Products.vue";
export default {
  name: "Dashboard",
  components: {
    MaintenanceProduct,
    Products,
    Plate,
  },
  created() {
    this.$store.dispatch("person/getMainPerson");
    this.$store.dispatch("product/getMaintenanceProduct");
  },
  computed: {
    mainPerson() {
      return this.$store.getters["person/mainPerson"];
    },
    maintenanceProduct() {
      return this.$store.getters["product/maintenanceProduct"];
    },
    labels() {
      return this.$store.getters["person/personLabels"];
    },
    productLabels() {
      return this.$store.getters["product/productLabels"];
    },
    subscription() {
      return this.$store.getters["subscription/subscription"];
    },
    subscriptionExpirationDate() {
      if (this.subscription) {
        return moment
          .unix(this.subscription.current_period_end)
          .format("DD/MM/YYYY");
      }
      return false;
    },
    personDeletionDate() {
      if (this.subscription) {
        return moment
          .unix(this.subscription.current_period_end)
          .add(1, "M")
          .format("DD/MM/YYYY");
      }
      return moment(this.mainPerson.created).add(1, "M").format("DD/MM/YYYY");
    },
  },
  methods: {
    productsUpdatedEvent(products) {
      this.$data.products = products;
    },
    async checkout() {
      const response = await ProductApi.checkout(this.$data.products);
      window.location.href = response.data;
    },
  },
};
</script>