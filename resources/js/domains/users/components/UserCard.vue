<template>
    <tr>
        <td>{{ user?.id }}</td>
        <td><input v-if="isEditing" v-model="form.first_name" required /><template v-else>{{ user?.first_name }}</template></td>
        <td><input v-if="isEditing" v-model="form.last_name" required /><template v-else>{{ user?.last_name }}</template></td>
        <td><input v-if="isEditing" v-model="form.email" type="email" required /><template v-else>{{ user?.email }}</template></td>
        <td>
            <select v-if="isEditing" v-model="form.role">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <template v-else>{{ user?.role }}</template>
        </td>
        <td><input v-if="isEditing" v-model="form.phone_number" /><template v-else>{{ user?.phone_number }}</template></td>
        <td>
            <template v-if="!isEditing">
                <template v-if="mode === 'list'">
                    <button @click.stop="Navigation.to('users.show', {id: user?.id})">View</button> |
                    <button class="delete" @click.stop="handleDelete">Delete</button>
                </template>
                <template v-else>
                    <button @click.stop="startEdit">Edit</button> |
                    <button class="delete" @click.stop="handleDelete">Delete</button>
                </template>
            </template>
            <template v-else>
                <button @click.stop="saveEdit">Save</button> |
                <button class="delete" @click.stop="cancelEdit">Cancel</button>
            </template>
        </td>
    </tr>
</template>

<script setup>
import {ref, reactive} from 'vue';
import {Navigation} from '../../../facades/router';
import {userStore} from '../store';

const props = defineProps({user: Object, mode: {type: String, default: 'list'},});

const isEditing = ref(false);
const form = reactive({first_name: '', last_name: '', email: '', role: '', phone_number: ''});

const startEdit = () => {
    form.first_name = props.user.first_name;
    form.last_name = props.user.last_name;
    form.email = props.user.email;
    form.role = props.user.role;
    form.phone_number = props.user.phone_number;
    isEditing.value = true;
};

const cancelEdit = () => {
    isEditing.value = false;
};

const saveEdit = async () => {
    await userStore.actions.update(props.user.id, {...form});
    isEditing.value = false;
};

const handleDelete = async () => {
    if (!confirm('Are you sure you want to delete this user?')) return;

    await userStore.actions.delete(props.user.id);
    
    if (props.mode === 'detail') {
        Navigation.to('users.index');
    }
};
</script>
