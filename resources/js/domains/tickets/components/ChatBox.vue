<template>
    <div class="chat-container">
        <form class="chat-form" @submit.prevent="handleSubmit">
            <input v-model="form.message" placeholder="Write a reply here" class="chat-input" required />

            <button type="submit" class="chat-submit">Send</button>
        </form>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import {authStore} from '../../Auth/store';

const props = defineProps({
    ticketId: {
        type: [String, Number],
        required: true,
    },
});

const emit = defineEmits(['submit']);

const form = ref({
    userId: null,
    ticketId: props.ticketId,
    message: '',
});

onMounted(async () => {
    const user = await authStore.actions.me();

    if (user && user.id) {
        form.value.userId = user.id;
    }
});

const handleSubmit = () => {
    emit('submit', {...form.value});

    form.value.message = '';
}
</script>
