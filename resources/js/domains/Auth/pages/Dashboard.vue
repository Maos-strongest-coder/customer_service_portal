<template>
    <h2>dashboard</h2>
  
    <button type="button" @click="handleLogout">Logout</button>

</template>

<script setup>
import {authStore} from '../store';
import {Navigation} from '../../../facades/router';

;

const handleLogout = async () => {
    await authStore.actions.logout();

    Navigation.to('dashboard');
};
</script>
