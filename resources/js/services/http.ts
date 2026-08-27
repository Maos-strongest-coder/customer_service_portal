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
        if (error.response && error.response.status === 400) {
            setMessage(error.response.data.message);
        }
        if (error.response && error.response.status === 422) {
            setErrorBag(error.response.data.errors);
            setMessage(error.response.data.message);
        }
        return Promise.reject(error);
    },
);

export default http;
