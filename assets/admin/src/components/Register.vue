<template>
  <b-container>
    <b-row>
      <b-col>
        <form>
          <b-row>
            <b-col>
              <b-form-group :label="labels.email">
                <b-input v-model="email"></b-input>
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
                @click="performRegister()"
              >
                {{ labels.register }}
              </b-button>
            </b-col>
          </b-row>
        </form>
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
  </b-container>
</template>

<script>
export default {
  name: "Register",
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

    if (this.$store.getters["security/isAuthenticated"]) {
      if (typeof redirect !== "undefined") {
        this.$router.push({ path: redirect });
      } else {
        this.$router.push({ path: "/" });
      }
    }
  },
  methods: {
    async performRegister() {
      let payload = { email: this.$data.email, password: this.$data.password },
        redirect = this.$route.query.redirect;

      await this.$store.dispatch("security/register", payload);
      if (!this.$store.getters["security/hasError"]) {
        this.$router.push({ path: "/login" });
      }
    },
  },
};
</script>