<template>
    <div>
        <h1>Create a Ticket</h1>
        <Form :ticket="ticket" @submit="handleSubmit" />
    </div>
</template>

<script setup>
import {ticketStore} from '../store';
import {ref} from 'vue';
import {Navigation} from '../../../facades/router';
import Form from '../components/Form.vue';

const ticket = ref({
    title: '',
    category_id: '',
});

const handleSubmit = async data => {
    await ticketStore.actions.create(data);

    Navigation.to('overview');


};
</script>
