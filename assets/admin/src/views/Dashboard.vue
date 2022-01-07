<template>
  <b-container>
    <b-row>
      <b-col>
        <b-img fluid src="/img/logo.png"></b-img>
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
        <p>
          {{ labels.subscription_active_until }}
          {{ subscriptionExpirationDate }}
        </p>
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
import MaintenanceProduct from "../components/Product/MaintenanceProduct.vue";
export default {
  name: "Dashboard",
  components: {
    MaintenanceProduct,
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
};
</script>