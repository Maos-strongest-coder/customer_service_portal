<template>
    <tr>
        <td>
            {{ ticket?.id }}
        </td>
        <td>
            {{ ticket?.title }}
        </td>

        <td>
            {{ ticket?.category?.name }}
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

        <template v-if="showActions">
            <td v-if="canManage">
                <button @click.stop="Navigation.to('tickets.edit', {id: ticket?.id})">Edit</button>
                |
                <button class="delete">Delete</button>
            </td>

            <td v-else>
                <span>Not Authorized</span>
            </td>
        </template>
    </tr>
</template>

<script setup>
import {isAdmin, currentUser} from '../../Auth/store';
import {computed} from 'vue';
import {Navigation} from '../../../facades/router';

const props = defineProps({
    ticket: Object,
    showActions: {
        type: Boolean,
        default: true,
    },
});


const canManage = computed(() => {
    return isAdmin.value || props.ticket?.issued_by?.id === currentUser.value?.id;
});
</script>
