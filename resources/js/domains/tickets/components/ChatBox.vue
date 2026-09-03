<template>
    <div class="chat-container">
        <form class="chat-form" @submit.prevent="handleSubmit">
            <input
                v-model="form.message"
                :placeholder="type === 'note' ? 'Write an internal note here...' : 'Write a reply here...'"
                class="chat-input"
                required
            />

            <button type="submit" class="chat-submit">
                {{ type === 'note' ? 'Add Note' : 'Send' }}
            </button>
        </form>
    </div>
</template>

<script setup>
import {ref} from 'vue';

const props = defineProps({
    ticketId: {
        type: [String, Number],
        required: true,
    },
    type: {
        type: String,
        default: 'reply',
    },
});

const emit = defineEmits(['submit']);

const form = ref({
    ticketId: props.ticketId,
    message: '',
});

const handleSubmit = () => {
    emit('submit', {
        ...form.value,
        type: props.type,
    });

    form.value.message = '';
};
</script>
