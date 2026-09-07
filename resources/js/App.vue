<script setup lang="ts">
import ErrorMessage from './domains/components/ErrorMessage.vue';
import {onMounted} from 'vue';
import {authStore} from './domains/Auth/store';

onMounted(async () => {
    await authStore.actions.me();
});
</script>

<template>
    <nav>
        <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
        |
        <router-link :to="{name: 'login'}">Login</router-link>
        |
        <router-link :to="{name: 'overview'}">Overview</router-link>
        |
        <router-link :to="{name: 'create'}">Report an Issue</router-link>
    </nav>
    <ErrorMessage />

    <router-view></router-view>
</template>
