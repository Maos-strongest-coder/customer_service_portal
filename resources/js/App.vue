<script setup lang="ts">
import ErrorMessage from './domains/components/ErrorMessage.vue';

</script>

<template>
    <nav>
        <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
        |
        <router-link :to="{name: 'login'}">Login</router-link>
        |
        <router-link :to="{name: 'overview'}">Overview</router-link>
    </nav>
    <ErrorMessage />

    <router-view></router-view>
</template>
