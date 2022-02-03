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
          {{ labels.no_persons }}
        </p>
        <b-button variant="primary" :to="{ name: 'CreatePerson' }">{{
          labels.create_person
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
        labels() {
            return this.$store.getters["person/personLabels"];
        },  
    }
}
</script>
