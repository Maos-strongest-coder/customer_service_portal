import Overview from './pages/Overview.vue';
import Show from './pages/Show.vue';
import Create from './pages/Create.vue';
import Edit from './pages/Edit.vue';

export const ticketRoutes = [
    {path: '/tickets', component: Overview, name: 'overview'},
    {path: '/tickets/create', component: Create, name: 'create'},
    {path: '/tickets/:id/edit', component: Edit, name: 'edit'},
    {path: '/tickets/:id', component: Show, name: 'show'},
];
