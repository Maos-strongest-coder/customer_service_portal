import {ref, computed} from 'vue';

export const errors = ref<Record<string, string[]>>({});
export const message = ref<string>('');

export const getErrors = computed(() => errors.value);
export const getMessage = computed(() => message.value);

export const getErrorByProperty = (property: string) => computed(() => errors.value[property]);

export const setErrorBag = (newErrors: Record<string, string[]>) => {
    errors.value = newErrors;
};
export const setMessage = (newMessage: string) => {
    message.value = newMessage;
};

export const destroyErrors = () => {
    errors.value = {};
};
export const destroyMessage = () => {
    message.value = '';
};
