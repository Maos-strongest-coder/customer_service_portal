<template>
    <div class="register-container">
        <h1>Create an Account</h1>

        <!-- @submit.prevent zorgt ervoor dat de pagina niet herlaadt -->
        <form @submit.prevent="handleRegister">
            <div>
                <label for="first_name">First Name:</label>
                <input v-model="form.first_name" type="text" required />
            </div>

            <div>
                <label for="last_name">Last Name:</label>
                <input v-model="form.last_name" type="text" required />
            </div>

            <div>
                <label for="email">Email Address:</label>
                <input v-model="form.email" type="email" required />
            </div>

            <div>
                <label for="password">Password:</label>
                <input v-model="form.password" type="password" required />
            </div>

            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input v-model="form.password_confirmation" type="password" required />
            </div>

            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { authStore } from '../store';
import { Navigation } from '../../../facades/router';

const form = ref({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const handleRegister = async () => {
    await authStore.actions.register(form.value);
    Navigation.to('tickets.overview');
};
</script>
