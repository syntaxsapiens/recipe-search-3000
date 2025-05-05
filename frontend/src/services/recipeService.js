import api from '../api/api.js';

export default {
  getRecipes(params = {}) {
    return api.get('/recipes', { params });
  },

  getRecipe(slug) {
    return api.get(`/recipes/${slug}`);
  },
};
