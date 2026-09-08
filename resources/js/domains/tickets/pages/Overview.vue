<template>
    <table>
        <thead><TicketTableHeader /></thead>
        <tbody><tr v-for="ticket in tickets" :key="ticket?.id" @click="Navigation.to('show', {id: ticket?.id})">
            <TicketCard :ticket="ticket" />
        </tr></tbody>
    </table>
</template>

<script setup>
import {onMounted} from 'vue';
import {ticketStore} from '../store';
import {Navigation} from '../../../facades/router';
import TicketCard from '../components/TicketCard.vue';
import TicketTableHeader from '../components/TicketTableHeader.vue';

const tickets = ticketStore.getters.all;

onMounted(async () => {
    await ticketStore.actions.getAll();
    console.log(tickets.value);
});
</script>
