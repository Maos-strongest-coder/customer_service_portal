<template>
    <div>
        <h2>Edit Ticket</h2>

        <div v-if="ticket">
            <strong>#{{ ticket.id }} — {{ ticket.title }}</strong>
            <span>{{ ticket.category?.name }}</span>
            <span>Status: {{ ticket.status }}</span>
            <span>Issued by: {{ ticket.issued_by?.full_name }}</span>
        </div>

        <Form v-if="ticket" :ticket="ticket" @submit="handleSubmit" />
    </div>
</template>

<script setup>
import { onMounted, computed } from 'vue';
import Form from '../components/Form.vue';
import { ticketStore } from '../store';
import { Navigation } from '../../../facades/router';

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