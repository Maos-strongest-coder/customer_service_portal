import Login from './pages/Login.vue';
import Dashboard from './pages/Dashboard.vue';
import Register from './pages/Register.vue';
import VerifyEmail from './pages/VerifyEmail.vue';

export const authRoutes = [
    {path: '/', component: Dashboard, name: 'dashboard', meta: {requiresAuth: true}},
    {path: '/login', component: Login, name: 'login', meta: {guestOnly: true}},
    {path: '/register', component: Register, name: 'register', meta: {guestOnly: true}},
    {path: '/verify-email', component: VerifyEmail, name: 'verify.email', meta: {requiresAuth: true}},
];
