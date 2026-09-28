<template>
    <form method="POST" @submit.prevent="handleSubmit">
        <div>
            <label for="email">Email:</label>
            <input id="email" v-model="form.email" type="email" name="email" placeholder="JohnDoe@email.com" required />
        </div>

        <button type="submit">Send reset link</button>
    </form>
</template>

<script setup>
import { ref } from 'vue';

    const emit = defineEmits(['submit']);

    const form = ref({
        email: '',
    });

    const handleSubmit = () => {
        emit('submit', {...form.value})
    };
</script>