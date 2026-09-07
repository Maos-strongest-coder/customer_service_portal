<template>
    <td>
        {{ ticket?.id }}
    </td>
    <td>
        {{ ticket?.title }}
    </td>

    <td>
        {{ ticket?.category.name }}
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

    <td v-if="isAdmin">
        <button>Edit</button>
        |
        <button class="delete">Delete</button>
    </td>
</template>

<script setup>
import {isAdmin} from '../../Auth/store';
import {Navigation} from '../../../facades/router';

defineProps({
    ticket: Object,
});
</script>
