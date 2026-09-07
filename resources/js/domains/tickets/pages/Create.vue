<template>
    <div>
        <h1>Create a Ticket</h1>
        <Form :ticket="ticket" @submit="handleSubmit" />
    </div>
</template>

<script setup>
import {ticketStore} from '../store';
import {ref, onMounted} from 'vue';
import {Navigation} from '../../../facades/router';
import {Http} from '../../../facades/http';
import {categoryStore} from '../../categories/store';
import Form from '../components/Form.vue';

const ticket = ref({
    title: '',
    category_id: '',
});

const categories = ref([
    {
        id: 0,
        name: '',
    }
]);



onMounted(async () => {
    await categoryStore.actions.getAll();

    categories.value = categoryStore.getters.all.value;
    
});

const handleSubmit = async data => {
    await ticketStore.actions.create(data);

    Navigation.to('overview');


};
</script>
