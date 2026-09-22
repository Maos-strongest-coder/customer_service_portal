<template>
    <div class="chat-container">
        <form class="chat-form" @submit.prevent="handleSubmit">
            <input
                v-model="message"
                :placeholder="placeholder"
                class="chat-input"
                required
            />

            <button type="submit" class="chat-submit">
                {{ buttonLabel }}
            </button>
        </form>
    </div>
</template>

<script setup>
import {ref} from 'vue';

const props = defineProps({
    placeholder: {
        type: String,
        default: 'Type a message...',
    },
    buttonLabel: {
        type: String,
        default: 'Send',
    },
});

const emit = defineEmits(['submit']);

const message = ref('');

const handleSubmit = () => {
    emit('submit', message.value);
    message.value = '';
};
</script>