import { router } from '../router';

export const Navigation = {
    to: (routeName: string, params = {}) => router.push({ name: routeName, params }),

    toPath: (path: string) => router.push(path),

    back: () => router.back(),
    
    currentRoute: () => router.currentRoute.value,
};