<template>
    <div>
        <h1>Create a Ticket</h1>
        <form @submit.prevent="handleSubmit">
            <div>
                <label for="title">Title:</label>
                <input v-model="ticket.title" type="text" required />
            </div>

            <div>
                <label for="category">Category:</label>

                <select v-model="ticket.category_id" required>
                    <option value="" disabled>Select a category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
        </form>
    </div>
</template>

<script setup>
import {ticketStore} from '../store';
import {ref, onMounted} from 'vue';
import {Navigation} from '../../../facades/router';

const ticket = ref({
    title: '',
    category: '',
});

const categories = ref([]);

const fetchCategories = async () => {
    const response = await Http.get('/categories');

    categories.value = response.data?.data;
};

onMounted(() => {
    fetchCategories();
});

const handleSubmit = async => {
    await ticketStore.actions.create(ticket.value);
    Navigation.to('overview');
};
</script>
