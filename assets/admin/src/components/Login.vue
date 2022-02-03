<template>
  <b-row no-gutters>
    <b-col>
      <!-- <b-card style="background-color: rgba(238, 238, 238, 0.7)"> -->
      <b-row>
        <b-col class="text-center">
          <form>
            <b-row>
              <b-col>
                <b-form-group :label="labels.email">
                  <b-input
                    v-model="email"
                    :placeholder="labels.email"
                  ></b-input>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <b-form-group :label="labels.password">
                  <b-input v-model="password" type="password"></b-input>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <b-button
                  :disabled="
                    email.length === 0 || password.length === 0 || isLoading
                  "
                  variant="primary"
                  @click="performLogin()"
                >
                  {{ labels.login }}
                </b-button>
              </b-col>
            </b-row>
          </form>
        </b-col>
      </b-row>
      <b-row>
        <b-col class="text-center">
          <b-link to="/register">{{ labels.no_account }}</b-link>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <div v-if="isLoading" class="row col">
            <p>Loading...</p>
          </div>

          <div v-else-if="hasError" class="row col">
            <div class="alert alert-danger" role="alert">
              {{ error }}
            </div>
          </div>
        </b-col>
      </b-row>
      <!-- </b-card> -->
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["security/isLoading"];
    },
    hasError() {
      return this.$store.getters["security/hasError"];
    },
    error() {
      return this.$store.getters["security/error"];
    },
    labels() {
      return this.$store.getters["label/defaultLabels"];
    },
  },
  created() {
    let redirect = this.$route.query.redirect;
    this.$store.dispatch("label/getDefaultLabels");

    if (this.$store.getters["security/isAuthenticated"]) {
      if (typeof redirect !== "undefined") {
        this.$router.push({ path: redirect });
      } else {
        this.$router.push({ path: "/" });
      }
    }
  },
  methods: {
    async performLogin() {
      let payload = { email: this.$data.email, password: this.$data.password },
        redirect = this.$route.query.redirect;

      await this.$store.dispatch("security/login", payload);
      if (!this.$store.getters["security/hasError"]) {
        if (typeof redirect !== "undefined") {
          this.$router.push({ path: redirect });
        }
      }
    },
  },
};
</script>