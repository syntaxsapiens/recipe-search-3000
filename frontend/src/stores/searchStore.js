import { defineStore } from 'pinia';

export const useSearchStore = defineStore('search', {
  state: () => ({
    keyword: '',
    ingredient: '',
    email: '',
    loading: false
  }),

  actions: {
    updateKeyword(value) {
      this.keyword = value;
    },

    updateIngredient(value) {
      this.ingredient = value;
    },

    updateEmail(value) {
      this.email = value;
    },

    resetFilters() {
      this.keyword = '';
      this.ingredient = '';
      this.email = '';
    },

    getSearchParams() {
      const params = {};
      if (this.keyword) params.keyword = this.keyword;
      if (this.ingredient) params.ingredient = this.ingredient;
      if (this.email) params.email = this.email;
      return params;
    }
  }
});
