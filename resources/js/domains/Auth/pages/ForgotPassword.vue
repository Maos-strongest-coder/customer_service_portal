

<template>
    <h2>Reset your password</h2>

    <ForgotPasswordForm @submit="handleForgotPassword" />
</template>

<script setup>
import {Http} from '../../../facades/http';
import ForgotPasswordForm from '../components/ForgotPasswordForm.vue';

const handleForgotPassword = async data => {
    await Http.post('/forgot-password', data);
};
</script>