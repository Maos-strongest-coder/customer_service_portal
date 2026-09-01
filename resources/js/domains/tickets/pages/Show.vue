<template>
    <div v-if="ticket">
        <h2>ticket #{{ ticket?.id }}</h2>

        <table>
            <thead>
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
            </thead>
            <tbody>
                <TicketCard :ticket="ticket" />
            </tbody>
        </table>

        <h2>Replies</h2>

        <div v-if="ticket.replies && ticket.replies.length > 0">
            <div v-for="reply in ticket.replies " :key="reply.id">
                <strong>{{ reply.user?.full_name }}</strong>
                |
                <span>{{ reply.created_at }}</span>

                <p>{{ reply.message }}</p>
            </div>
        </div>

        <div v-else>No replies yet.</div>

        <ChatBox :ticketId="ticket.id" @submit="handleSubmit"/>
    </div>

    
</template>

<script setup>
import {computed, onMounted, ref} from 'vue';
import {ticketStore} from '../store';
import {Navigation} from '../../../facades/router';
import TicketCard from '../components/TicketCard.vue';
import ChatBox from '../components/ChatBox.vue';
import { Http } from '../../../facades/http';

const currentId = ref(null);

const ticket = computed(() => {
    if (!currentId.value) return null;
    return ticketStore.getters.getById(currentId.value).value;
});

onMounted(async () => {
    const currentRoute = Navigation.currentRoute();

    const ticketId = currentRoute.params.id;

    if (ticketId) {
        currentId.value = ticketId;
        await ticketStore.actions.getOne({id: ticketId});
    }
});

const handleSubmit = async (formData) => {
    await Http.post(`/tickets/${formData.ticketId}/replies`, {
        message: formData.message
    });

    await ticketStore.actions.getOne({ id: formData.ticketId})
}
</script>
