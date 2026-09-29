<template>
    <tr>
        <td>
            {{ ticket?.id }}
        </td>

         <td>
            <input v-if="isEditing && canManage" v-model="form.title" required />
            <template v-else>{{ ticket?.title }}</template>
        </td>

        <td>
            <select v-if="isEditing && canManage" v-model="form.category_id" required>
                <option disabled value="">Select a category</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
            <template v-else>{{ ticket?.category?.name }}</template>
        </td>

        <td>
            <select v-if="isEditing && isAdmin" v-model="form.status" required>
                <option value="open">Open</option>
                <option value="in_progress">In Progress</option>
                <option value="closed">Closed</option>
            </select>
            <template v-else>{{ ticket?.status }}</template>
        </td>

        <td>
            {{ ticket?.issued_by?.full_name }}
        </td>
        <td>
            {{ ticket?.created_at }}
        </td>
        <td>
            {{ ticket?.updated_at }}
        </td>

         <td>
            <select v-if="isEditing && isAdmin" v-model="form.issued_to_id" required>
                <option disabled value="">Select an admin to pick up this ticket</option>
                <option v-for="admin in admins" :key="admin.id" :value="admin.id">
                    {{ admin.full_name }}
                </option>
            </select>
            <template v-else>{{ ticket?.issued_to?.full_name }}</template>
        </td>

        <template v-if="showActions">
            <td v-if="!isEditing">
                <template v-if="mode === 'list'">
                    <button @click.stop="Navigation.to('tickets.show', {id: ticket?.id})">View</button>
                    |
                    <button v-if="isAdmin" class="delete" @click.stop="handleDelete">Delete</button>
                </template>
                <template v-else-if="canManage">
                    <button @click.stop="startEdit">Edit</button>
                    |
                    <button v-if="isAdmin" class="delete" @click.stop="handleDelete">Delete</button>
                </template>
                <template v-else>
                    <span>Not Authorized</span>
                </template>
            </td>
            <td v-else>
                <button @click.stop="saveEdit">Save</button>
                |
                <button class="delete" type="button" @click.stop="cancelEdit">Cancel</button>
            </td>
        </template>
    </tr>
</template>

<script setup>
import {ref, reactive, computed} from 'vue';
import {categoryStore} from '../../categories/store';
import {userStore} from '../../users/store';
import {isAdmin, currentUser} from '../../Auth/store';
import {Navigation} from '../../../facades/router';
import {ticketStore} from '../store';

const props = defineProps({
    ticket: Object,
    mode: {type: String, default: 'list'},
    showActions: {type: Boolean, default: true},
});


const canManage = computed(() => {
    return isAdmin.value || props.ticket?.issued_by?.id === currentUser.value?.id;
});

const isEditing = ref(false);

const form = reactive({
    title: '',
    category_id: '',
    status: '',
    issued_to_id: '', 
});

const categories = categoryStore.getters.all;
const admins = computed(() => {
    return (userStore.getters.all.value || []).filter(user => user.role === 'admin')
});

const startEdit = async () => {
    form.title = props.ticket.title;
    form.category_id = props.ticket.category?.id ;
    form.status = props.ticket.status ;
    form.issued_to_id = props.ticket.issued_to?.id ;

    if (categories.value.length === 0) await categoryStore.actions.getAll();
    if (isAdmin.value && admins.value.length === 0) await userStore.actions.getAll();

    isEditing.value = true;
};

const cancelEdit = () => { isEditing.value = false; };

const buildPayload = () => {
    const payload = {title: form.title, category_id: form.category_id};
    if (isAdmin.value) {
        payload.status = form.status;
        payload.issued_to_id = form.issued_to_id;
    }
    return payload;
};

const saveEdit = async () => {
    await ticketStore.actions.update(props.ticket.id, buildPayload());
    isEditing.value = false;
};

const handleDelete = async () => {
    if (!confirm('Are you sure you want to delete this ticket?')) return;
    await ticketStore.actions.delete(props.ticket.id);
    if (props.mode === 'detail') Navigation.to('tickets.overview');
};
</script>
