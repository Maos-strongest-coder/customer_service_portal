import Login from './pages/Login.vue';
import Dashboard from './pages/Dashboard.vue';
import Register from './pages/Register.vue';
import VerifyEmail from './pages/VerifyEmail.vue';
import ForgotPassword from './pages/ForgotPassword.vue';
import ResetPassword from './pages/ResetPassword.vue';

export const authRoutes = [
    {path: '/', component: Dashboard, name: 'dashboard', meta: {requiresAuth: true}},
    {path: '/login', component: Login, name: 'login', meta: {guestOnly: true}},
    {path: '/register', component: Register, name: 'register', meta: {guestOnly: true}},
    {path: '/verify-email', component: VerifyEmail, name: 'verify.email', meta: {requiresAuth: true}},
    {path: '/forgot-password', component: ForgotPassword, name: 'forgot-password', meta: {guestOnly: true}},
    {path: '/reset-password', component: ResetPassword, name: 'reset-password', meta: {guestOnly: true}}
];
