import {storeModuleFactory} from '../../factories/storeFactory';
import {Http} from '../../facades/http';
import { computed } from 'vue';
import axios from 'axios';

export const authStore = {
    ...storeModuleFactory('auth'),
};

authStore.actions = { ...authStore.actions, 
    login: async (credentials: {email: string, password: string}) => {
        await axios.get('/sanctum/csrf-cookie', {withCredentials: true});
        const response = await Http.post('login', credentials);

        const data = response;

        if (!data) return;

        authStore.setters.setOne(data);
    },

    logout: async () => {
        await Http.post('logout');

        authStore.setters.setOne(null);
    },

    me: async () => {
        const data = await Http.get('me');

        if (!data?.user) return null;

        authStore.setters.setOne(data.user);
        return data.user;
    },
} 

export const currentUser = computed(() => authStore.getters.all.value[0] || null);

export const isAdmin = computed(() => currentUser.value?.role === 'admin');

export const getRole = computed(() => currentUser.value?.role || 'user');
