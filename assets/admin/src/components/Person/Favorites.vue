<template>
  <b-container>
    <b-row>
      <b-button @click="addFavourite">{{ labels.add_favourite }}</b-button>
    </b-row>
    <b-row v-for="(favorite, index) in favorites" v-bind:key="favorite.id">
      <b-col cols="3">
        <b-form-group :label="labels.favorite_type">
          <b-form-input
            :placeholder="labels.favorite_type_placeholder"
            v-model="favorites[index].type"
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group :label="labels.favorites">
          <b-form-tags
            separator=","
            v-model="favorites[index].favorites"
          ></b-form-tags>
        </b-form-group>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  name: "Favorites",
  props: {
    person: {
      type: Object,
      required: false,
      default: null,
    },
  },
  mounted() {
    if (this.$props.person) {
      this.$data.favorites = this.$props.person.favorites;
    }
  },
  computed: {
    labels() {
      return this.$store.getters["label/personLabels"];
    },
  },
  watch: {
    favorites() {
      this.$emit("favoritesChanged", this.$data.favorites);
    },
  },
  data() {
    return {
      favorites: [],
    };
  },
  methods: {
    addFavourite() {
      this.$data.favorites.push({
        type: "",
        favorites: [],
      });
    },
  },
};
</script>