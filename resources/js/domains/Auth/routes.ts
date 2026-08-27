import Login from './pages/Login.vue';
import Dashboard from './pages/Dashboard.vue';

export const authRoutes = [
    {path: '/', component: Dashboard, name: 'dashboard'},
    {path: '/login', component: Login, name: 'login'},
];
