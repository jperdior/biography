<template>
  <b-container>
    <b-row>
      <b-col>
        <h1>{{ personLabels.welcome }}</h1>
      </b-col>
    </b-row>
    <dashboard-persons></dashboard-persons>
    <b-row v-if="subscription">
      <b-col>
    <b-tabs>
      <b-tab title="Vista general" active>
        <b-row v-if="subscription && persons.lenght">
          <b-col>
            <b-row>
              <b-col>
                <p>
                  {{ personLabels.subscription_active_until }}
                  {{ subscriptionExpirationDate }}
                </p>
              </b-col>
            </b-row>
            <plate :person="persons[0]"></plate>
            <!-- <b-row>
              <b-col>
                <products @productsUpdated="productsUpdatedEvent"> </products>
              </b-col>
            </b-row> -->
            <b-row>
              <b-col>
                <b-button @click="checkout">{{
                  productLabels.checkout
                }}</b-button>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
        <b-row v-else>
          <b-col>
            <maintenance-product
              v-if="maintenanceProduct"
              :product="maintenanceProduct"
            ></maintenance-product>
          </b-col>
        </b-row>
      </b-tab>
      <b-tab title="Moderar mensajes del memorial">
        <notes-admin-list></notes-admin-list>
      </b-tab>
    </b-tabs>
      </b-col></b-row>
  </b-container>
</template>
<script>
import moment from "moment";
import Plate from "../components/Person/Plate.vue";
import NotesAdminList from "../components/Note/NotesAdminList.vue";
import MaintenanceProduct from "../components/Product/MaintenanceProduct.vue";
import Products from "../components/Product/Products.vue";
import DashboardPersons from "../components/Dashboard/DashboardPersons.vue";
export default {
  name: "Dashboard",
  components: {
    MaintenanceProduct,
    NotesAdminList,
    Products,
    Plate,
    DashboardPersons
  },
  created() {
    this.$store.dispatch("person/getPersons");
    this.$store.dispatch("note/getAdminNotes");
    //this.$store.dispatch("product/getMaintenanceProduct");
  },
  computed: {
    persons(){
      return this.$store.getters["person/persons"];
    },
    maintenanceProduct() {
      return this.$store.getters["product/maintenanceProduct"];
    },
    personLabels() {
      return this.$store.getters["label/personLabels"];
    },
    productLabels() {
      return this.$store.getters["label/productLabels"];
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