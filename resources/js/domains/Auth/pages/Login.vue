<template>
    <h2>Login</h2>
    <LoginForm @submit="handleSubmit" />
</template>

<script setup>
import LoginForm from '../components/LoginForm.vue';
import {authStore} from '../store';
import {Navigation} from '../../../facades/routerFacade.js';

const handleSubmit = async credentials => {
    await authStore.actions.login(credentials);
    Navigation.toPath('/');
};
</script>
