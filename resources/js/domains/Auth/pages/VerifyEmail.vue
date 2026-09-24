<template>
    <div>
        <h2>Verify your email</h2>
        <p>Please check your inbox and click the verification link before continuing.</p>

        <button type="button" @click="handleResend" :disabled="sending">
            {{ sending ? 'Sending...' : 'Resend verification email' }}
        </button>

        <p v-if="sent">Verification email sent — check your inbox.</p>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import {authStore} from '../store';

const sending = ref(false);
const sent = ref(false);

const handleResend = async () => {
    sending.value = true;
    sent.value = false;

    try {
        await authStore.actions.resendVerification();
        sent.value = true;
    } finally {
        sending.value = false;
    }
};
</script>
