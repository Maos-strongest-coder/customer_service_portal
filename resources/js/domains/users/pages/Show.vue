<script setup lang="ts">
import {onMounted, watch, ref, nextTick, computed} from 'vue';
import UserCard from '../components/UserCard.vue';
import UserTableHeader from '../components/UserTableHeader.vue';
import {Navigation} from '../../../facades/router.js';
import {userStore} from '../store.js';

const userId = ref(null);

const user = computed(() => {
    if (!userId.value) return null;
    return userStore.getters.getById(userId.value).value;
});

onMounted(async () => {
    await userStore.getters.getById(userId.value);
});

watch(
    () => Navigation.currentRoute().params.id,
    async id => {
        if (!id) return;

        userId.value = id;

        await userStore.actions.getOne({id});

        await nextTick();
    },

    {immediate: true},
);
</script>

<template>
    <table>
        <thead>
            <UserTableHeader />
        </thead>

        <tbody>
            <UserCard :user="user" mode="detail"/>
        </tbody>
    </table>
</template>

