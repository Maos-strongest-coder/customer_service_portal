<template>
    <div v-if="ticket">
        <thead>
            <TicketTableHeader :showActions="isAdmin" />
        </thead>

        <tbody>
            <TicketCard :ticket="ticket" />
        </tbody>
        

        <template v-if="isAdmin">
            <NotesTable ref="notesTableRef" :ticketId="currentId" />
            <ChatBox :ticketId="ticket.id" type="note" @submit="handleChatSubmit" />
        </template>
        <div>
            <h2>Replies</h2>

            <div v-if="ticket.replies && ticket.replies.length > 0">
                <div v-for="reply in ticket.replies" :key="reply.id">
                    <strong>{{ reply.user?.full_name }}</strong>
                    |
                    <span>{{ reply.created_at }}</span>

                    <div v-if="editReplyId === reply.id">
                        <form @submit.prevent="handleUpdateReplySubmit(reply.id)">
                            <input v-model="editFormMessage" required />
                            <button type="submit">Save</button>
                            |
                            <button type="button" @click="cancelEditReply">Cancel</button>
                        </form>
                    </div>

                    <div v-else>
                        <p>{{ reply.message }}</p>
                        <div v-if="isAdmin">
                            <button @click="startEditReply(reply)">Edit</button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else>No replies yet.</div>

            <ChatBox v-if="isAdmin" :ticketId="ticket.id" type="reply" @submit="handleChatSubmit" />
        </div>
    </div>
</template>

<script setup>
import {computed, watch, ref, nextTick} from 'vue';
import {ticketStore} from '../store';
import {Navigation} from '../../../facades/router';
import TicketCard from '../components/TicketCard.vue';
import ChatBox from '../components/ChatBox.vue';
import NotesTable from '../components/NotesTable.vue';
import {Http} from '../../../facades/http';
import {isAdmin} from '../../Auth/store';
import TicketTableHeader from '../components/TicketTableHeader.vue';

const currentId = ref(null);
const notesTableRef = ref(null);

const editReplyId = ref(null);
const editFormMessage = ref('');

const ticket = computed(() => {
    if (!currentId.value) return null;
    return ticketStore.getters.getById(currentId.value).value;
});

const startEditReply = reply => {
    editReplyId.value = reply.id;
    editFormMessage.value = reply.message;
};

const cancelEditReply = () => {
    editReplyId.value = null;
    editFormMessage.value = '';
};

watch(
    () => Navigation.currentRoute().params.id,
    async (id) => {
        if (!id) return;

        currentId.value = id;

        await ticketStore.actions.getOne({ id });
        

        if (isAdmin.value) {
            await nextTick();

            if (notesTableRef.value) {
                await notesTableRef.value.fetchNotes();
            }
        }
    },

    { immediate: true }
);

const handleChatSubmit = async formData => {
    if (formData.type === 'note') {
        await notesTableRef.value.addNote(formData.message);
    } else {
        await Http.post(`/tickets/${formData.ticketId}/replies`, {
            message: formData.message,
        });
        await ticketStore.actions.getOne({id: formData.ticketId});
    }
};

const handleUpdateReplySubmit = async replyId => {
    await Http.put(`/tickets/${currentId.value}/replies/${replyId}`, {
        message: editFormMessage.value,
    });
    cancelEditReply();
    await ticketStore.actions.getOne({id: currentId.value});
};
</script>
