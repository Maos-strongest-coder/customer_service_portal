<template>
    <h2>dashboard</h2>
    <button type="button" @click="loadCurrentUser">Get current user</button>
    |
    <button type="button" @click="handleLogout">Logout</button>

    <div>current user is {{ currentUser }}</div>
</template>

<script setup>
import {ref} from 'vue';
import {authStore} from '../store';
import {Navigation} from '../../../facades/routerFacade';

const currentUser = ref(null);

const loadCurrentUser = async () => {
    const user = await authStore.actions.me();
    if (user) {
        currentUser.value = user.first_name;
    } else {
        currentUser.value = null;

        Navigation.toPath('/');
    }
};

const handleLogout = async () => {
    await authStore.actions.logout();

    Navigation.toPath('/');
};
</script>
