<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useSearchStore } from '@/stores/searchStore';
import IngredientAutocomplete from '@/components/ingredient-autocomplete/IngredientAutocomplete.vue';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

const searchStore = useSearchStore();
const router = useRouter();
const route = useRoute();

const form = ref({
    ingredient: '',
    keyword: '',
    email: ''
});

function syncWithRoute() {
    form.value.ingredient = route.query.ingredient || '';
    form.value.keyword = route.query.keyword || '';
    form.value.email = route.query.email || '';
    searchStore.updateIngredient(form.value.ingredient);
    searchStore.updateKeyword(form.value.keyword);
    searchStore.updateEmail(form.value.email);
}

onMounted(syncWithRoute);
watch(() => route.query, syncWithRoute, { deep: true });

function handleSearch() {
    const query = {};
    if (form.value.ingredient) query.ingredient = form.value.ingredient;
    if (form.value.keyword) query.keyword = form.value.keyword;
    if (form.value.email) query.email = form.value.email;
    router.push({ query });
}

function handleReset() {
    form.value = { ingredient: '', keyword: '', email: '' };
    router.push({ query: {} });
    searchStore.resetFilters();
}
</script>

<template>
    <Card class="w-full m-2 p-2">
        <template #title>Search by...</template>
        <template #content>
            <form @submit.prevent="handleSearch">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ingredient</label>
                        <IngredientAutocomplete
                            v-model="form.ingredient"
                            placeholder="Search by ingredient..."
                            class="w-full"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keyword</label>
                        <InputText
                            type="text"
                            v-model="form.keyword"
                            placeholder="Search by keyword..."
                            class="w-full"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <InputText
                            type="email"
                            v-model="form.email"
                            placeholder="Search by email..."
                            class="w-full"
                        />
                    </div>
                    <div class="flex items-center justify-end space-x-4 h-full">
                        <Button type="submit" class="p-button-primary" label="Search" />
                        <Button type="button" @click="handleReset" class="p-button-secondary" label="Reset" />
                    </div>
                </div>
            </form>
        </template>
    </Card>
</template>
