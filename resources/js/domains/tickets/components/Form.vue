<template>
    <div>
        <form @submit.prevent="handleSubmit">
            <div>
                <label for="title">Title:</label>
                <input v-model="form.title" type="text" required />
            </div>

            <div>
                <label for="category">Category:</label>

                <select v-model="form.category_id" required>
                    <option disabled value="">Select a category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <template v-if="isAdmin">
                <div>
                    <label for="status">Status:</label>
                    <select v-model="form.status" required>
                        <option disabled value="">Select a status</option>
                        <option v-for="status in ticketStatuses" :key="status.value" :value="status.value">{{ status.label }}</option>
                    </select>
                </div>

                <div>
                    <label for="issued_to">Issued To:</label>
                    <select v-model="form.issued_to_id" required>
                        <option disabled value="">Select an admin to pick up this ticket</option>
                        <option v-for="admin in admins" :key="admin.id" :value="admin.id">
                            {{ admin.full_name }}
                        </option>
                    </select>
                </div>
            </template>
            <button type="submit">Create Ticket</button>
        </form>
    </div>
</template>

<script setup>
import {ref, onMounted, computed} from 'vue';
import {categoryStore} from '../../categories/store';
import {userStore} from '../../users/store';
import {isAdmin} from '../../Auth/store';

const categories = categoryStore.getters.all;
const users = userStore.getters.all;

const ticketStatuses = [
    {value: 'open', label: 'Open'},
    {value: 'started', label: 'In Progress'},
]

onMounted(async () => {
    await categoryStore.actions.getAll();
    if (isAdmin.value) {
        await userStore.actions.getAll();
    }
});

const admins = computed(() => {
    return (users.value || []).filter(user => user.role === 'admin');
});

const props = defineProps({ticket: Object});

const emit = defineEmits(['submit']);

const form = ref({
    title: props.ticket?.title || '',
    category_id: props.ticket?.category?.id || '',
    status: props.ticket?.status || '',
    issued_to_id: props.ticket?.issued_to?.id || '',
});

const handleSubmit = () => emit('submit', form.value);
</script>
