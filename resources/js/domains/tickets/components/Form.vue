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

            <button type="submit">Create Ticket</button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import {categoryStore} from '../../categories/store';

const categories = categoryStore.getters.all;

onMounted(() => {
    categoryStore.actions.getAll();
});

const props = defineProps({ ticket: Object });

const emit = defineEmits(['submit']);

const form = ref({ ...props.ticket });

const handleSubmit = () => emit('submit', form.value);
</script>