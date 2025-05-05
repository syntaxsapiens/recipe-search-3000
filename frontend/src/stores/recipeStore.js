import { defineStore } from 'pinia';
import recipeService from '@/services/recipeService';

export const useRecipeStore = defineStore('recipe', {
  state: () => ({
    recipes: [],
    recipe: null,
    loading: false,
    error: null,
    pagination: {
        perPage: 12,
        total: 0,
        from: 0
    }
  }),

  actions: {
    async fetchRecipes(params) {
      this.loading = true;
      try {
        const response = await recipeService.getRecipes({
          ...params
        });
        this.recipes = response.data.data.recipes;
        this.pagination = {
            perPage: response.data.data.meta.per_page,
            total: response.data.data.meta.total,
            from: response.data.data.meta.from
        };
      } catch (error) {
        this.error = error.response.data.message;
      } finally {
        this.loading = false;
      }
    },

    async fetchRecipe(slug) {
      this.loading = true;
      try {
        const response = await recipeService.getRecipe(slug);
        this.recipe = response.data.data;
      } catch (error) {
        this.error = error.message;
      } finally {
        this.loading = false;
      }
    }
  }
});
