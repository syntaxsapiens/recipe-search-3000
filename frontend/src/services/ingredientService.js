import api from '../api/api.js';

export default {
    getIngredientSuggestions(query) {
        return api.get('/ingredients/suggest', {
            params: { query }
        });
    }
};
