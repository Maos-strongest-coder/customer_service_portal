import Login from './pages/Login.vue';
import Dashboard from './pages/Dashboard.vue';
import Register from './pages/register.vue';


export const authRoutes = [
    {path: '/', component: Dashboard, name: 'dashboard'},
    {path: '/login', component: Login, name: 'login'},
    {path: '/register', component: Register, name: 'register' }
];
