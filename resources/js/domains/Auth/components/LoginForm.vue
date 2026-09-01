<template>
    <form method="POST" @submit.prevent="handleSubmit">
        <div>
            <label for="email">Email:</label>
            <input id="email" v-model="form.email" type="email" name="email" placeholder="JohnDoe@email.com" required />
        </div>

        <div>
            <label for="password">Password:</label>
            <input
                id="password"
                v-model="form.password"
                type="password"
                name="password"
                placeholder="********"
                required
            />
        </div>

        <button type="submit">Log in</button>
    </form>
</template>

<script setup>
import {ref} from 'vue';

const emit = defineEmits(['submit']);

const form = ref({
    email: '',
    password: '',
});

const handleSubmit = () => {
    emit('submit', {...form.value});
};
</script>
