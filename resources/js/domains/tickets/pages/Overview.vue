<template>
    <ErrorMessage />

    <table>
        <tr>
            <th>Ticket ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Issued By</th>
            <th>Issued On</th>
            <th>Last Update On</th>
            <th>Issued To</th>
        </tr>
        <tr v-for="ticket in tickets" :key="ticket?.id"
            @click="Navigation.toPath(`/tickets/${ticket.id}`)"
        >
        
            <TicketCard :ticket="ticket" />
        </tr>
    </table>
</template>

<script setup>
import {onMounted, computed} from 'vue';
import {ticketStore} from '../store';
import ErrorMessage from '../../components/ErrorMessage.vue';
import { Navigation } from '../../../facades/router';
import TicketCard from '../components/TicketCard.vue';

const tickets = ticketStore.getters.all;

onMounted(async () => {
    await ticketStore.actions.getAll();
    console.log(tickets.value);
});

</script>
