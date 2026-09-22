<template>
    <table>
        <thead>
            <UserTableHeader />
        </thead>

        <tbody>
            <UserCard v-for="user in users" :key="user?.id" :user="user" />
        </tbody>
    </table>
</template>

<script setup>
import UserCard from '../components/UserCard.vue';
import UserTableHeader from '../components/UserTableHeader.vue';
import {userStore} from '../store.js';
import {onMounted} from 'vue';

const users = userStore.getters.all;

onMounted(async () => {
    await userStore.actions.getAll();
});
</script>
