<template>
    <ErrorMessage />

    <form method="POST" @submit.prevent="handleSubmit">
        <div class="mb-4">
            <label name="email" class="block">Email:</label>
            <input
                v-model="form.email"
                type="email"
                name="email"
                class="border p-2"
                placeholder="JohnDoe@email.com"
                required
            />
            <FormError name="email" />
        </div>

        <div class="mb-4">
            <label name="password" class="block">Password:</label>
            <input
                v-model="form.password"
                type="password"
                name="password"
                class="border p-2"
                placeholder="********"
                required
            />
            <FormError name="password" />
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2">Log in</button>
    </form>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import ErrorMessage from '../../components/ErrorMessage.vue';
import FormError from '../../components/FormError.vue';

const props = defineProps({auth: Object});

const emit = defineEmits(['submit']);

const form = ref({...props.auth});

const handleSubmit = () => emit('submit', form.value);
</script>
