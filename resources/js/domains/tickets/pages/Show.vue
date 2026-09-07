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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <TicketCard :ticket="ticket" />
            </tbody>
        </table>

        <div v-if="isAdmin" class="admin-notes-section">
            <h3>Internal Notes</h3>
            <table>
                <thead>
                    <tr>
                        <th>Admin</th>
                        <th>Note</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <template v-if="notes && notes.length > 0">
                        <tr v-for="note in notes" :key="note.id">
                            <td>{{ note.user?.full_name }}</td>

                            <td>
                                <div v-if="editNoteId === note.id">
                                    <form :id="'form-' + note.id" @submit.prevent="handleUpdateNoteSubmit(note.id)">
                                        <input v-model="editNoteMessage" required />
                                    </form>
                                </div>
                                <div v-else>
                                    {{ note.message }}
                                </div>
                            </td>

                            <td>{{ note.created_at }}</td>

                            <td>
                                <template v-if="editNoteId !== note.id">
                                    <button @click="startEditNote(note)">Edit</button>
                                    |
                                    <button class="delete" @click="handleDeleteNote(note.id)">Delete</button>
                                </template>

                                <template v-else>
                                    <button type="submit" :form="['form-' + note.id]">Save</button>
                                    |
                                    <button class="delete" type="button" @click="cancelEditNote">Cancel</button>
                                </template>
                            </td>
                        </tr>
                    </template>

                    <tr v-else>
                        <td colspan="4">No notes available.</td>
                    </tr>
                </tbody>
            </table>

            <ChatBox :ticketId="ticket.id" type="note" @submit="handleChatSubmit" />
        </div>

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

            <ChatBox :ticketId="ticket.id" type="reply" @submit="handleChatSubmit" />
        </div>
    </div>
</template>

<script setup>
import {computed, onMounted, ref} from 'vue';
import {ticketStore} from '../store';
import {Navigation} from '../../../facades/router';
import TicketCard from '../components/TicketCard.vue';
import ChatBox from '../components/ChatBox.vue';
import {Http} from '../../../facades/http';
import {isAdmin} from '../../Auth/store';
import {authStore} from '../../Auth/store';

const currentId = ref(null);

const editReplyId = ref(null);
const editFormMessage = ref('');

const editNoteId = ref(null);
const editNoteMessage = ref('');

const notes = ref([]);

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

const startEditNote = note => {
    editNoteId.value = note.id;
    editNoteMessage.value = note.message;
};

const cancelEditNote = () => {
    editNoteId.value = null;
    editNoteMessage.value = '';
};

const deleteNote = async noteId => {
    await Http.delete(`/tickets/${currentId.value}/notes/${noteId}`);
    await fetchNotes(currentId.value);
};

const fetchNotes = async ticketId => {
    const response = await Http.get(`/tickets/${ticketId}/notes`);
    notes.value = response.data || response || [];
};

onMounted(async () => {
    const currentRoute = Navigation.currentRoute();
    const ticketId = currentRoute.params.id;

    if (ticketId) {
        currentId.value = ticketId;

        await authStore.actions.me();

        await ticketStore.actions.getOne({id: ticketId});

        if (isAdmin.value) {
            await fetchNotes(ticketId);
        }
    }
});

const handleChatSubmit = async formData => {
    if (formData.type === 'note') {
        await Http.post(`/tickets/${formData.ticketId}/notes`, {
            message: formData.message,
        });
        await fetchNotes(formData.ticketId);
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

const handleUpdateNoteSubmit = async noteId => {
    await Http.put(`/tickets/${currentId.value}/notes/${noteId}`, {
        message: editNoteMessage.value,
    });
    cancelEditNote();
    await fetchNotes(currentId.value);
};

const handleDeleteNote = async noteId => {
    if (confirm('Are you sure you want to delete this note?')) {
        await Http.delete(`/tickets/${currentId.value}/notes/${noteId}`);

        await fetchNotes(currentId.value);
    }
};
</script>
