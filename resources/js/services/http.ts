import axios from 'axios';
import {destroyErrors, destroyMessage, setErrorBag, setMessage} from './error';

const http = axios.create({
    baseURL: '/api',
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
});

http.interceptors.request.use(
    config => {
        destroyErrors();
        destroyMessage();
        return config;
    },
    error => Promise.reject(error),
);

http.interceptors.response.use(
    response => {
        if (response.data && response.data.message) {
            setMessage(response.data.message);
        }
        return response;
    },
    error => {
        if (error.response?.data?.message) {
            setMessage(error.response.data.message);
        }
        if (error.response?.status === 422) {
            setErrorBag(error.response.data.errors);
        }
        return Promise.reject(error);
    },
);
export const getCsrfCookie = () => axios.get('/sanctum/csrf-cookie', {withCredentials: true});

export default http;
