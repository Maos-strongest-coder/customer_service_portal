import {createRouter, createWebHistory} from 'vue-router';
import {authRoutes} from '../domains/Auth/routes.js';
import {ticketRoutes} from '../domains/tickets/routes.js';
import {categoryRoutes} from '../domains/categories/routes.js';
import {authReady, currentUser, isAdmin, isVerified} from '../domains/Auth/store.js';
import {userRoutes} from '../domains/users/routes.js';

export const router = createRouter({
    history: createWebHistory(),
    routes: [...authRoutes, ...ticketRoutes, ...categoryRoutes, ...userRoutes],
});

router.beforeEach(async to => {
    await authReady;
    const isLoggedIn = !!currentUser.value;

    if (to.meta.requiresAuth && !isLoggedIn) {
        return {name: 'login'};
    }

    if (to.meta.requiresVerified && isLoggedIn && !isVerified.value) {
        return {name: 'verify.email'};
    }

    if (to.meta.requiresAdmin && !isAdmin.value) {
        return {name: 'dashboard'};
    }

    if (to.meta.guestOnly && isLoggedIn) {
        return {name: 'dashboard'};
    }
});
