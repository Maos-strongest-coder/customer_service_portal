<template>
    <tr>
        <th>Ticket ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Issued By</th>
        <th>Issued On</th>
        <th>Last Update On</th>
        <th>Issued To</th>
        <template v-if="showActions"><th>Actions</th></template>
        
    </tr>
</template>

<script setup>
const props = defineProps({
    showActions: {
        type: Boolean,
        default: true,
    },
});
</script>