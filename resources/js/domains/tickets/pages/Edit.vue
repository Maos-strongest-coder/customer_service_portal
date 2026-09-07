<template>
    <div>
        <h2>Edit Ticket</h2>
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
        <tr>
            <TicketCard :ticket="ticket" :showActions="false" />
        </tr>
    </table>
        <Form v-if="ticket" :ticket="ticket" @submit="handleSubmit" />
    </div>
</template>

<script setup>
import { onMounted, computed } from 'vue';
import Form from '../components/Form.vue';
import { ticketStore } from '../store';
import { Navigation } from '../../../facades/router';
import TicketCard from '../components/TicketCard.vue';



const ticketId = Number(Navigation.currentRoute().params.id);

onMounted(() => {
    ticketStore.actions.getOne({ id: ticketId });
});

const ticket = computed(() => ticketStore.getters.getById(ticketId).value);

const handleSubmit = async (data) => {
    await ticketStore.actions.update(ticketId, data);
    
    //Navigation.to('show', { id: ticketId });
};
</script>