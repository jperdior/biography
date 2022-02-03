<template>
  <b-container>
    <b-row>
      <b-col>
        <h1>{{ labels.welcome }}</h1>
      </b-col>
    </b-row>
    <dashboard-persons></dashboard-persons>
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
import DashboardPersons from "../components/Dashboard/DashboardPersons.vue";
export default {
  name: "Dashboard",
  components: {
    MaintenanceProduct,
    Products,
    Plate,
    DashboardPersons
  },
  created() {
    this.$store.dispatch("person/getPersons");
    this.$store.dispatch("product/getMaintenanceProduct");
  },
  computed: {
    persons(){
      return this.$store.getters["person/persons"];
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