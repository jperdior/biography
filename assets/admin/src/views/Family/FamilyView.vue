<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <b-link :to="{ name: 'CreatePerson', params: { familyId: family.id } }"
          >Create person</b-link
        >
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <VueFamilyTree :tree="tree">
          <template v-slot:card="{ item }">
            <div class="custom-card">
              <div
                :style="{
                  backgroundImage: item.image ? `url(${item.image})` : null,
                }"
                class="custom-card__image"
              />
              <div class="custom-card__info">
                <div class="custom-card__name">
                  {{ item.name }}
                </div>
                <div v-show="item.age" class="custom-card__age">
                  Age: {{ item.age }}
                </div>
              </div>
            </div>
          </template>
        </VueFamilyTree>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import VueFamilyTree from "../../components/FamilyTree/VueFamilyTree.vue";
export default {
  name: "FamilyView",
  components: {
    VueFamilyTree,
  },
  // beforeRouteUpdate(to, from, next) {
  //   this.$store.dispatch("family/getFamily", to.params.id);
  //   next();
  // },
  mounted() {
    this.$store.dispatch("family/getFamily", this.$route.params.id);
  },
  computed: {
    family() {
      return this.$store.getters["family/family"];
    },
  },
  data() {
    return {
      tree: [
        {
          firstPerson: {
            name: "John Walker",
            image: "https://picsum.photos/300/300?random=1",
          },
          secondPerson: {
            name: "-------",
          },
          children: [
            {
              firstPerson: {
                name: "Katia",
              },
            },
            {
              firstPerson: {
                name: "Katia",
              },
              secondPerson: {
                name: "Manuel",
              },
            },
          ],
        },
      ],
    };
  },
};
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 60px;
}
.text-center {
  text-align: center;
  margin-bottom: 32px;
}
.custom-card {
  display: flex;
  align-items: center;
  width: 220px;
  padding: 16px;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-sizing: border-box;
  background-color: #fff;
  cursor: pointer;
  box-shadow: 0 0 6px 2px rgba(#000, 0);
  transition: box-shadow 0.2s ease;
  &:hover {
    box-shadow: 0 0 6px 2px rgba(#000, 0.1);
  }
  &__image {
    flex: 0 0 auto;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: #dedede;
    background-size: cover;
    background-position: 50%;
  }
  &__info {
    padding-left: 16px;
  }
  &__name {
    font-weight: 600;
  }
  &__age {
    margin-top: 4px;
    font-size: 12px;
  }
}
</style>