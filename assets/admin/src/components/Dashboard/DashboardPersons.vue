<template>
<b-row>
    <b-col>
        <b-row v-if="persons.lenght">
            <b-col cols="4" v-for="person in persons" v-bind:key="person.id">
                <dashboard-person-card :person="person"></dashboard-person-card>
            </b-col>
        </b-row>
        <b-row v-else>
            <p>
          {{ personLabels.no_persons }}
        </p>
        <b-button variant="primary" :to="{ name: 'CreatePerson' }">{{
          personLabels.create_memorial
        }}</b-button>
        </b-row>
    </b-col>
</b-row>
</template>
<script>
import DashboardPersonCard from "./DashboardPersonCard.vue";
export default{
    name:"DashboardPersons",
    components:{
        DashboardPersonCard
    },
    computed:{
        persons(){
            return this.$store.getters["person/persons"];
        },
        personLabels() {
            return this.$store.getters["label/personLabels"];
        },  
    }
}
</script>
