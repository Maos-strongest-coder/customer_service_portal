import Overview from './pages/Overview.vue';
import Show from './pages/Show.vue';

export const userRoutes = [
    {path: '/users', component: Overview, name: 'users.overview', meta: {requiresAdmin: true}},
    {path: '/users/:id', component: Show, name: 'users.show', meta: {requiresAdmin: true}},
];
