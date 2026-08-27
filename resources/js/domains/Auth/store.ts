import {storeModuleFactory} from '../../factories/storeFactory';
import {Http} from '../../facades/http';
import axios from 'axios';

export const authStore = storeModuleFactory('auth');

authStore.actions.login = async credentials => {
    await Http.get('/sanctum/csrf-cookie', {withCredentials: true});
    const response = await Http.post('login', credentials);

    const data = response.data;

    if (!data) return;

    authStore.setters.setOne(data);
};

authStore.actions.logout = async () => {
    await Http.post('logout');

    authStore.setters.setOne(null);
};

authStore.actions.me = async () => {
    const data = await Http.get('me');

    if (!data?.user) return null;

    authStore.setters.setOne(data.user);
    return data.user;
};
