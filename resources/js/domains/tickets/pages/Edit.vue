<template>
    <div>
        <h2>Ticket Details</h2>

        <div v-if="ticket">
        <thead>
            <TicketTableHeader :showActions="false" />
        </thead>

        <tbody>
            <TicketCard :ticket="ticket" :showActions="false" />
        </tbody>
        </div>
        
        <h2>Update Ticket</h2>
        
        <Form v-if="ticket" :ticket="ticket" @submit="handleSubmit" />
    </div>
</template>

<script setup>
import { onMounted, computed } from 'vue';
import Form from '../components/Form.vue';
import { ticketStore } from '../store';
import { Navigation } from '../../../facades/router';
import TicketCard from '../components/TicketCard.vue';
import TicketTableHeader from '../components/TicketTableHeader.vue';

const ticketId = Number(Navigation.currentRoute().params.id);

onMounted(() => {
    ticketStore.actions.getOne({ id: ticketId });
});

const ticket = computed(() => ticketStore.getters.getById(ticketId).value);

const handleSubmit = async (data) => {
    await ticketStore.actions.update(ticketId, data);
    
    Navigation.to('show', { id: ticketId });
};
</script>