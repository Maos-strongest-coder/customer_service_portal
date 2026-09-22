import Overview from './pages/Overview.vue';



export const categoryRoutes = [
    {path: '/categories', component: Overview, name: 'categories.overview', meta: {requiresAuth: true}},
];
