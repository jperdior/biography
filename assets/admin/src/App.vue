<template>
<b-container>
  <router-view ></router-view>
<b-modal v-model="isLoading" :no-close-on-backdrop="true" :no-close-on-esc="true" :hide-footer="true" :hide-header="true">
      
        <b-spinner class="mx-2"></b-spinner>
        Cargando información...
      
</b-modal>
</b-container>
</template>

<script>
export default {
  name: "App",
  mounted(){
    this.$store.dispatch("person/getPersonLabels");
  },
  computed: {
    isLoading: {
      get: function () {
        return this.$store.getters["person/loading"];
      },
      set: function () {
      },
    },
  }
}
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
