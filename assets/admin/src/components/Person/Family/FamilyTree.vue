<template>
  <span>
    <b-button @click="showFamilyTree()">{{ labels.show_family_tree }}</b-button>
    <b-modal ref="familyTreeModal" size="lg">
      <b-row>
        <b-col>
          <VueFamilyTree :tree="tree" />
        </b-col>
      </b-row>
    </b-modal>
  </span>
</template>
<script>
import PersonApi from "../../../api/person.js";
import VueFamilyTree from "../../FamilyTree/VueFamilyTree.vue";
export default {
  name: "FamilyTree",
  components: {
    VueFamilyTree,
  },
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
    tree() {
      let tree = [];
      let parentsObject = {
        firstPerson: null,
        secondPerson: null,
        children: [],
      };
      if (this.$props.person.parents[0]) {
        parentsObject.firstPerson = {
          name:
            this.$props.person.parents[0].name +
            " " +
            this.$props.person.parents[0].lastnames,
          image: this.$props.person.parents[0].mainPictureBase64,
        };
      }
      if (this.$props.person.parents[1]) {
        parentsObject.secondPerson = {
          name:
            this.$props.person.parents[1].name +
            " " +
            this.$props.person.parents[1].lastnames,
          image: this.$props.person.parents[1].mainPictureBase64,
        };
      }
      let childrenArray = [];
      if (this.$props.person.children.length) {
        for (let i = 0; i < this.$props.person.children.length; i++) {
          childrenArray.push({
            firstPerson: {
              name:
                this.$props.person.children[i].name +
                " " +
                this.$props.person.children[i].lastnames,
              image: this.$props.person.children[i].mainPictureBase64,
            },
          });
        }
      }
      parentsObject.children = [
        {
          firstPerson: {
            name: this.$props.person.name + " " + this.$props.person.lastnames,
            image: this.$props.person.mainPictureBase64,
          },
          secondPerson: {
            name: "",
          },
          children: childrenArray,
        },
      ];
      tree.push(parentsObject);
      return tree;
    },
  },
  methods: {
    showFamilyTree() {
      this.$refs.familyTreeModal.show();
    },
    async getFamiliarImage(familiarId) {
      const response = await PersonApi.getFamiliarMainPicture(familiarId);
      return response.data;
    },
    async getPersonImage(personId) {
      const response = await PersonApi.getPersonMainPicture(personId);
      return response.data;
    },
  },
};
</script>