<script setup>
import { ref, watch } from 'vue';
import ingredientService from '@/services/ingredientService.js';
import AutoComplete from 'primevue/autocomplete';

const props = defineProps({
    placeholder: String,
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);

const value = ref(props.modelValue || "");
const items = ref([]);

watch(() => props.modelValue, (newValue) => {
    value.value = newValue;
});

watch(() => value.value, (newValue) => {
    emit('update:modelValue', newValue);
});

const search = async (event) => {
    try {
        const response = await ingredientService.getIngredientSuggestions(event.query);
        items.value = response.data.data.map(item => item.name);
    } catch (error) {
        items.value = [];
    }
};
</script>

<template>
    <AutoComplete v-model="value" :suggestions="items" @complete="search" :placeholder="placeholder" inputClass="w-full" />
</template>
