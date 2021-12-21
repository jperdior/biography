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
import VueFamilyTree from "../FamilyTree/VueFamilyTree.vue";
export default {
  name: "FamilyTree",
  components: {
    VueFamilyTree,
  },
  props: {
    person: {
      type: Object,
      required: false,
      default: null,
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
        };
      }
      if (this.$props.person.parents[1]) {
        parentsObject.secondPerson = {
          name:
            this.$props.person.parents[0].name +
            " " +
            this.$props.person.parents[0].lastnames,
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
            },
          });
        }
      }
      parentsObject.children = [
        {
          firstPerson: {
            name: this.$props.person.name + " " + this.$props.person.lastnames,
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
  },
};
</script>