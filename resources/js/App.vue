<script setup lang="ts">
import ErrorMessage from './domains/components/ErrorMessage.vue';
</script>

<template>
    <nav>
        <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
        |
        <router-link :to="{name: 'login'}">Login</router-link>
        |
        <router-link :to="{name: 'tickets.overview'}">Tickets</router-link>
        |
        <router-link :to="{name: 'tickets.create'}">Report an Issue</router-link>
        |
        <router-link :to="{name: 'register'}">Register an Account</router-link>
        |
        <router-link :to="{name: 'categories.overview'}">Categories</router-link>
        |
        <router-link :to="{name: 'users.overview'}">View Users</router-link>
    </nav>
    <ErrorMessage />

    <router-view></router-view>
</template>
