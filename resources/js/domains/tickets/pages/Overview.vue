<template>
    <ErrorMessage />

    <table>
        <tr>
            <th>Ticket ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Issued By</th>
            <th>Issued On</th>
            <th>Last Update On</th>
            <th>Issued To</th>
        </tr>
        <tr v-for="ticket in tickets" :key="ticket?.id">
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
                {{ ticket?.issued_by }}
            </td>
            <td>
                {{ ticket?.created_at }}
            </td>
            <td>
                {{ ticket?.updated_at }}
            </td>
            <td>
                {{ ticket?.issued_to }}
            </td>

            <td>
                <button>Edit</button>
                |
                <button>Delete</button>
            </td>
        </tr>
    </table>
</template>

<script setup>
import {onMounted, computed} from 'vue';
import {ticketStore} from '../store';
import ErrorMessage from '../../components/ErrorMessage.vue';

const tickets = ticketStore.getters.all;

onMounted(async () => {
    await ticketStore.actions.getAll();
    console.log(tickets.value);
});
</script>
