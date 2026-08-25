import { ref } from 'vue';

export const errors = ref<Record<string, string[]>>({});
export const message = ref<string>('');

export const setErrorBag = (newErrors: Record<string, string[]>) => { errors.value = newErrors; };
export const setMessage = (newMessage: string) => { message.value = newMessage; };

export const destroyErrors = () => { errors.value = {}; };
export const destroyMessage = () => { message.value = ''; };