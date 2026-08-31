import Overview from './pages/Overview.vue';
import Show from './pages/Show.vue';

export const ticketRoutes = [
    {path: '/tickets', component: Overview, name: 'overview'}, 
    {path: '/tickets/:id', component: Show, name: 'show'}];
