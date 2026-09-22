<script setup>
import {ref, onMounted} from 'vue';
import {isAdmin} from '../../Auth/store';
import { categoryStore } from '../store';


const categories = categoryStore.getters.all;

const editCategoryId = ref(null);
const editCategoryName = ref('');

onMounted(async () => {
    await categoryStore.actions.getAll();
});

const addCategory = async name => {
    await categoryStore.actions.create({name});
};

const startEditCategory = category => {
    editCategoryId.value = category.id;
    editCategoryName.value = category.name;
};

const cancelEditCategory = () => {
    editCategoryId.value = null;
    editCategoryName.value = '';
};

const handleUpdateCategorySubmit = async categoryId => {
    await categoryStore.actions.update(categoryId, {name: editCategoryName.value})
    cancelEditCategory();
};

const handleDeleteCategory = async categoryId => {
    if (confirm('Are you sure you want to delete this category?')) {
        await categoryStore.actions.delete(categoryId);
    }
};

defineExpose({ addCategory});
</script>

<template>
    <div>
    <h3>Categories</h3>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th v-if="isAdmin">Actions</th>
            </tr>
        </thead>

        <tbody>
            <template v-if="categories && categories.length > 0">
                <tr v-for="category in categories" :key="category.id">
                    <td>
                        <div v-if="editCategoryId === category.id">
                            <form :id="'form-' + category.id" @submit.prevent="handleUpdateCategorySubmit(category.id)">
                                <input v-model="editCategoryName" required />
                            </form>
                        </div>
                        <div v-else>
                            {{ category.name }}
                        </div>
                    </td>

                    <td v-if="isAdmin">
                        <template v-if="editCategoryId !== category.id">
                            <button @click="startEditCategory(category)">Edit</button>
                            |
                            <button class="delete" @click="handleDeleteCategory(category.id)">Delete</button>
                        </template>

                        <template v-else>
                            <button type="submit" :form="'form-' + category.id">Save</button>
                            |
                            <button class="delete" type="button" @click="cancelEditCategory">Cancel</button>
                        </template>
                    </td>
                </tr>
            </template>

            <tr v-else>
                <td colspan="2">No Categories available.</td>
            </tr>
        </tbody>
    </table>
    </div>
</template>