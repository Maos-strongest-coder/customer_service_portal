import {createRouter, createWebHistory} from 'vue-router';
import {authRoutes} from '../domains/Auth/routes.js';

export const router = createRouter({
    history: createWebHistory(),
    routes: [...authRoutes],
});
