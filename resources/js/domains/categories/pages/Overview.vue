<script setup lang="ts">
import {ref} from 'vue'
import Table from '../components/Table.vue';
import ChatBox from '../../components/ChatBox.vue';
import { isAdmin } from '../../Auth/store';

const tableRef = ref(null);

const handleAddCategory = async name => {
    await tableRef.value.addCategory(name)
};
</script>

<template>
    <Table ref="tableRef" />
    <ChatBox v-if="isAdmin" placeholder="New category name..." buttonLabel="Add Category" @submit="handleAddCategory" />
</template>