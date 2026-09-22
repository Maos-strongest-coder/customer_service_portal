<template>
    <tr>
        <td>
            {{ user?.id }}
        </td>
        <td>
            {{ user?.first_name }}
        </td>

        <td>
            {{ user?.last_name }}
        </td>
        <td>
            {{ user?.email }}
        </td>
        <td>
            {{ user?.role }}
        </td>
        <td>
            {{ user?.phone_number }}
        </td>

        <td>
            <button @click.stop="Navigation.to('users.show', {id: user?.id})">View</button>
            |
            <button class="delete">Delete</button>
        </td>
    </tr>
</template>

<script setup>
import {Navigation} from '../../../facades/router';
const props = defineProps({
    user: Object,
});
</script>
