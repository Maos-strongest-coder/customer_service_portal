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
            <ChatBox placeholder="Write an internal note here..." buttonLabel="Add Note" @submit="handleAddNote" />
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

            <ChatBox v-if="isAdmin || ticket.issued_by?.id === currentUser?.id" placeholder="Write a reply here..." buttonLabel="Send" @submit="handleAddReply" />
        </div>
    </div>
</template>

<script setup>
import {computed, watch, ref, nextTick} from 'vue';
import {ticketStore} from '../store';
import {Navigation} from '../../../facades/router';
import TicketCard from '../components/TicketCard.vue';
import ChatBox from '../../components/ChatBox.vue';
import NotesTable from '../components/NotesTable.vue';
import {Http} from '../../../facades/http';
import {isAdmin, currentUser} from '../../Auth/store';
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

const handleAddNote = async message => {
    await notesTableRef.value.addNote(message);
};

const handleAddReply = async message => {
    await Http.post(`/tickets/${currentId.value}/replies`, {message});
    await ticketStore.actions.getOne({id: currentId.value});
};

const handleUpdateReplySubmit = async replyId => {
    await Http.put(`/tickets/${currentId.value}/replies/${replyId}`, {
        message: editFormMessage.value,
    });
    cancelEditReply();
    await ticketStore.actions.getOne({id: currentId.value});
};
</script>
