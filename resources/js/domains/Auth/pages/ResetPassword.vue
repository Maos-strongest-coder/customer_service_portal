<template>
    <h2>Choose a new password</h2>

    <p v-if="!isValid">This reset link is invalid.</p>

    <template v-else>
        <p>Resetting password for <strong>{{ email }}</strong></p>
        <ResetPasswordForm @submit="handleReset" />
    </template>
</template>

<script setup>
import {computed} from 'vue';
import {Http} from '../../../facades/http';
import {Navigation} from '../../../facades/router';
import ResetPasswordForm from '../components/ResetPasswordForm.vue';

const route = Navigation.currentRoute();

const token = computed(() => route.query.token);
const email = computed(() => route.query.email);
const isValid = computed(() => Boolean(token.value && email.value));

const handleReset = async formData => {
    await Http.post('/reset-password', {
        token: token.value,
        email: email.value,
        ...formData,
    });
    Navigation.to('login');
};
</script>