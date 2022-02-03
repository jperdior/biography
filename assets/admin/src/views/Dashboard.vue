<template>
  <b-container>
    <b-tabs>
      <b-tab title="Vista general" active>
        <b-row>
          <b-col md="2">
            <vue-ellipse-progress
              :progress="mainPerson.completenessPercent"
            ></vue-ellipse-progress>
          </b-col>
          <b-col>
            <b-button
              variant="success"
              :to="{ name: 'EditPerson', params: { id: mainPerson.id } }"
              >{{ personLabels.edit_memorial }}</b-button
            >
            <b-button
              variant="info"
              :to="{ name: 'Person', params: { id: mainPerson.id } }"
            >
              {{ personLabels.view_memorial }}
            </b-button>
          </b-col>
        </b-row>
        <b-row v-if="subscription">
          <b-col>
            <b-row>
              <b-col>
                <p>
                  {{ personLabels.subscription_active_until }}
                  {{ subscriptionExpirationDate }}
                </p>
              </b-col>
            </b-row>
            <plate :person="mainPerson"></plate>
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
            <p>{{ personLabels.subscription_inactive }}</p>
            <p>
              {{ personLabels.data_will_be_deleted }} {{ personDeletionDate }}
            </p>
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
  </b-container>
</template>
<script>
import moment from "moment";
import Plate from "../components/Person/Plate.vue";
import NotesAdminList from "../components/Note/NotesAdminList.vue";
import MaintenanceProduct from "../components/Product/MaintenanceProduct.vue";
import Products from "../components/Product/Products.vue";
export default {
  name: "Dashboard",
  components: {
    MaintenanceProduct,
    NotesAdminList,
    Products,
    Plate,
  },
  created() {
    this.$store.dispatch("person/getMainPerson");
    this.$store.dispatch("note/getAdminNotes");
    this.$store.dispatch("product/getMaintenanceProduct");
  },
  computed: {
    mainPerson() {
      return this.$store.getters["person/mainPerson"];
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