<template>
  <b-container fluid>
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-navbar-brand class="ml-auto">
        <router-link class="navbar-brand" to="/"> RECORDARI </router-link>
      </b-navbar-brand>

      <b-navbar-nav class="ml-auto">
        <ul class="navbar-nav">
          <li v-if="isAuthenticated" class="nav-item">
            <b-button
              variant="outline-danger"
              class="nav-link"
              href="/api/security/logout"
              >{{ labels.logout }}</b-button
            >
          </li>
        </ul>
      </b-navbar-nav>
    </b-navbar>
    <router-view></router-view>
    <b-modal
      :no-close-on-backdrop="true"
      :no-close-on-esc="true"
      :hide-footer="true"
      :hide-header="true"
      v-if="isLoading"
      :visible="isLoading"
      centered
    >
      <b-spinner class="mx-2"></b-spinner>
      Cargando información...
    </b-modal>
  </b-container>
</template>

<script>
import axios from "axios";
export default {
  name: "App",
  created() {
    this.$store.dispatch("person/getPersonLabels");
    this.$store.dispatch("product/getEcommerceLabels");
    let isAuthenticated = JSON.parse(
        this.$parent.$el.attributes["data-is-authenticated"].value
      ),
      user = JSON.parse(this.$parent.$el.attributes["data-user"].value);

    let payload = { isAuthenticated: isAuthenticated, user: user };
    this.$store.dispatch("security/onRefresh", payload);

    axios.interceptors.response.use(undefined, (err) => {
      return new Promise(() => {
        if (err.response.status === 401) {
          this.$router.push({ path: "/login" });
        } else if (err.response.status === 500) {
          // document.open();
          // console.log(err.response.data);
          // document.write(err.response.data);
          // document.close();
        }
        throw err;
      });
    });
  },
  computed: {
    isLoading() {
      return (
        this.$store.getters["person/loading"] ||
        this.$store.getters["product/loading"] ||
        this.$store.getters["subscription/loading"] ||
        this.$store.getters["security/isLoading"]
      );
    },
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"];
    },
    labels() {
      return this.$store.getters["person/personLabels"];
    },
  },
  watch: {
    isAuthenticated: {
      handler: function (newValue, oldValue) {
        if (newValue) {
          this.$store.dispatch("subscription/getSubscription");
        }
      },
      deep: true,
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
