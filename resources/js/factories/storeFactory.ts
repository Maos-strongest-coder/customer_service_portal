import {ref, computed} from 'vue';
import {Http} from '../facades/http';

export const storeModuleFactory = (moduleName: string) => {
    const state = ref<Record<string | number, any>>({});

    const getters = {
        all: computed(() => Object.values(state.value)),

        getById: (id: string | number) => computed(() => state.value[id]),
    };

    const setters = {
        setAll: (items: any[]) => {
            state.value = {};
            for (const item of items) {
                state.value[item.id] = Object.freeze(item);
            }
        },

        setOne: (item: any) => {
            if (!item) {
                state.value = {};
                return;
            }
            state.value[item.id] = Object.freeze(item);
        },

        deleteByItem: (item: {id: string | number}) => {
            delete state.value[item.id];
        },
    };

    const actions = {
        getAll: async () => {
            const data = await Http.get(`/${moduleName}`);
            console.log('Ruwe API data voor', moduleName, ':', data);
            if (!data) return;
            setters.setAll(data);
        },

        create: async (item: any) => {
            const data = await Http.post(`/${moduleName}`, item);
            if (!data) return;
            setters.setOne(data);
        },

        update: async (id: string | number, item: any) => {
            const data = await Http.put(`/${moduleName}/${id}`, item);
            if (!data) return;
            setters.setOne(data);
        },

        delete: async (id: string | number) => {
            await Http.delete(`/${moduleName}/${id}`);
            setters.deleteByItem({id});
        },
    };

    return {getters, setters, actions};
};
