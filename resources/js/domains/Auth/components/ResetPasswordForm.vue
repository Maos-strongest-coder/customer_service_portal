<template>
    <form method="POST" @submit.prevent="handleSubmit">
        <div>
            <label for="password">New password:</label>
            <input
                id="password"
                v-model="form.password"
                type="password"
                name="password"
                placeholder="********"
                required
            />
        </div>

        <div>
            <label for="password_confirmation">Confirm password:</label>
            <input
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                name="password_confirmation"
                placeholder="********"
                required
            />
        </div>

        <button type="submit">Reset password</button>
    </form>
</template>

<script setup>
import {ref} from 'vue';

const emit = defineEmits(['submit']);

const form = ref({
    password: '',
    password_confirmation: '',
});

const handleSubmit = () => {
    emit('submit', {...form.value});
};
</script>