<script setup>
import { computed, onMounted, watch } from 'vue';
import { useRecipeStore } from '@/stores/recipeStore';
import RecipeCard from './RecipeCard.vue';
import Paginator from 'primevue/paginator';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const recipeStore = useRecipeStore();

const isLoading = computed(() => recipeStore.loading);
const hasRecipes = computed(() => recipeStore.recipes.length > 0);
const hasError = computed(() => recipeStore.error);

watch(() => route.query, (newQuery) => {
  recipeStore.fetchRecipes(newQuery);
}, { deep: true });

onMounted(() => {
  recipeStore.fetchRecipes(route.query);
});

function onPageChange(event) {
  const newPage = event.page + 1;
  const newQuery = { ...route.query };
  if (newPage > 1) {
    newQuery.page = newPage;
  } else {
    delete newQuery.page;
  }

  router.push({ query: newQuery });
}
</script>

<template>
  <div>
    <div v-if="isLoading" class="flex justify-center my-8">
      <div class="loader">Loading...</div>
    </div>

    <div v-else-if="!hasRecipes || hasError" class="text-center my-8 text-gray-500">
      No recipes found. Try adjusting your search criteria.
    </div>

    <div v-else>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <RecipeCard
          v-for="recipe in recipeStore.recipes"
          :key="recipe.id"
          :recipe="recipe"
        />
      </div>
         <Paginator
            :rows="recipeStore.pagination.perPage"
            :totalRecords="recipeStore.pagination.total"
            :first="recipeStore.pagination.from"
            @page="onPageChange($event)"
            template="PrevPageLink NextPageLink"
        />
    </div>
  </div>
</template>
