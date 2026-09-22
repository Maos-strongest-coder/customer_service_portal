<script setup>
import {ref} from 'vue';
import {Http} from '../../../facades/http';
import {isAdmin} from '../../Auth/store';

const props = defineProps({
    ticketId: {
        type: [String, Number],
        required: true,
    },
});

const notes = ref([]);
const editNoteId = ref(null);
const editNoteMessage = ref('');

const fetchNotes = async () => {
    if (!isAdmin) {
        return 
    }
    const response = await Http.get(`/tickets/${props.ticketId}/notes`);
    notes.value = response.data || response || [];
};

const addNote = async message => {
    await Http.post(`/tickets/${props.ticketId}/notes`, {message});
    await fetchNotes();
};

const startEditNote = note => {
    editNoteId.value = note.id;
    editNoteMessage.value = note.message;
};

const cancelEditNote = () => {
    editNoteId.value = null;
    editNoteMessage.value = '';
};

const handleUpdateNoteSubmit = async noteId => {
    await Http.put(`/tickets/${props.ticketId}/notes/${noteId}`, {
        message: editNoteMessage.value,
    });
    cancelEditNote();
    await fetchNotes();
};

const handleDeleteNote = async noteId => {
    if (confirm('Are you sure you want to delete this note?')) {
        await Http.delete(`/tickets/${props.ticketId}/notes/${noteId}`);
        await fetchNotes();
    }
};

defineExpose({fetchNotes, addNote});
</script>

<template>
    <div>
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
                            <button type="submit" :form="'form-' + note.id">Save</button>
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
    </div>
</template>