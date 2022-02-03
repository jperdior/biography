<template>
  <b-row no-gutters>
    <b-col>
      <b-row no-gutters>
        <b-col>
          <!-- <carousel :items="1"> -->
          <div
            :style="
              'display: flex;flex-flow: column; width: 100%; height: ' +
              windowHeight +
              'px;padding-top:70px;'
            "
          >
            <div
              style="
                display: flex;
                flex-flow: column;
                width: 100%;
                height: 100%;
                background-color: rgba(238, 238, 238, 0.7);
                position: absolute;
                top: 0;
              "
            ></div>
            <b-row no-gutters style="z-index: 20">
              <b-col
                sm="12"
                md="8"
                offset-md="2"
                class="text-center"
                style="text-shadow: 1px 1px 2px #333; padding-top: 5%"
              >
                <h3 v-html="personLabels.recordari_meaning"></h3>
              </b-col>
            </b-row>
            <b-row no-gutters class="mt-4">
              <b-col class="text-center">
                <login-modal></login-modal>
                <register-modal></register-modal>
              </b-col>
            </b-row>
            <b-row no-gutters class="mt-4">
              <b-col
                sm="12"
                md="8"
                offset-md="2"
                class="text-center"
                style="text-shadow: 1px 1px 2px #333; font-size: 24px"
              >
                En Recordari la familia podrá crear un memorial para su ser
                querido, donde podrá honrar su recuerdo con su biografía,
                fotografías, anécdotas y sus amigos y familiares podrán visitar
                el memorial.
              </b-col>
            </b-row>
            <b-row no-gutters class="mt-4">
              <b-col class="text-center">
                <b-button variant="primary" to="/about">{{
                  personLabels.know_more
                }}</b-button>
              </b-col>
            </b-row>
          </div>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>
<script>
//background-image: url(\'/img/slide1-min.jpg\');background-size: cover
import LoginModal from "../components/LoginModal.vue";
import RegisterModal from "../components/RegisterModal.vue";
import carousel from "vue-owl-carousel";
export default {
  name: "Home",
  components: {
    LoginModal,
    carousel,
    RegisterModal,
  },
  created() {
    if (this.isAuthenticated) {
      this.$router.push("/dashboard");
    }
  },
  mounted() {
    this.$nextTick(() => {
      window.addEventListener("resize", this.onResize);
    });
  },
  data() {
    return {
      slide: 0,
      sliding: null,
      windowHeight: window.innerHeight,
    };
  },
  computed: {
    personLabels() {
      return this.$store.getters["label/personLabels"];
    },
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"];
    },
  },
  watch: {
    isAuthenticated() {
      if (this.isAuthenticated) {
        this.$router.push("/dashboard");
      }
    },
  },
  methods: {
    onResize() {
      this.windowHeight = window.innerHeight;
    },
  },
};
</script>
<style>
.carousel-inner > .item {
  position: relative;
  max-height: 400px;
}
.carousel-caption {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}
.navbar-inner {
  background: transparent;
}
</style>