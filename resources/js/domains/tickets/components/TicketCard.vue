<template>
    <td>
        {{ ticket?.id }}
    </td>
    <td>
        {{ ticket?.title }}
    </td>
    
    <td>
        {{ ticket?.category }}
    </td>
    <td>
        {{ ticket?.status }}
    </td>
    <td>
        {{ ticket?.issued_by?.full_name }}
    </td>
    <td>
        {{ ticket?.created_at }}
    </td>
    <td>
        {{ ticket?.updated_at }}
    </td>
    <td>
        {{ ticket?.issued_to?.full_name }}
    </td>

    <td>
        <button>Edit</button>
        |
        <button>Delete</button>
    </td>
</template>

<script setup>
    defineProps({
        ticket: Object,
    })
</script>