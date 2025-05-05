<script setup>
import { onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useRecipeStore } from '@/stores/recipeStore';
import Card from 'primevue/card';
import Button from 'primevue/button';

const route = useRoute();
const router = useRouter();
const recipeStore = useRecipeStore();

const recipe = computed(() => recipeStore.recipe);
const isLoading = computed(() => recipeStore.loading);
const hasError = computed(() => recipeStore.error);

onMounted(async () => {
  await recipeStore.fetchRecipe(route.params.slug);
  if (hasError.value) {
    router.push({ name: 'home' });
  }
});
</script>

<template>
  <div class="container mx-auto px-4 py-8">
    <Button
      @click="router.push({ name: 'home' })"
      class="mb-8"
    >
      ← Back to Recipes
    </Button>

    <div v-if="isLoading" class="flex justify-center my-8">
      <div class="loader">Loading...</div>
    </div>
    <Card v-else-if="recipe">
      <template #header>
          <img
              :alt="recipe.title"
              :title="recipe.title"
              :src="recipe.image"
              class="w-full h-[500px] object-cover"
          />
      </template>
      <template #title>{{ recipe.title }}</template>
      <template #subtitle>By {{ recipe.user.name }} ({{ recipe.user.email }})</template>
      <template #content>
          <p>
              {{ recipe.description }}
          </p>
          <div class="mt-8">
          <h2 class="text-xl font-medium">Ingredients</h2>
          <ul class="list-disc pl-5 space-y-1">
              <li v-for="(ingredient, index) in recipe.ingredients" :key="index" class="text-gray-700">
                  {{ ingredient.quantity }} {{ ingredient.unit }} {{ ingredient.name }}
              </li>
          </ul>
          </div>
          <div class="mt-8">
          <h2 class="text-xl font-medium">Instructions</h2>
          <ol class="list-decimal pl-5 space-y-4">
              <li v-for="(step, index) in recipe.steps" :key="index" class="text-gray-700">
                  {{ step.instruction }}
              </li>
          </ol>
          </div>
      </template>
    </Card>
  </div>
</template>
