<script setup>
import { defineProps } from 'vue';
import { RouterLink } from 'vue-router';
import Button from 'primevue/button';
import Card from 'primevue/card';

defineProps({
  recipe: Object
});
</script>

<template>
    <Card>
        <template #header>
            <img
                :alt="recipe.title"
                :title="recipe.title"
                :src="recipe.image"
            />
        </template>
        <template #title>{{ recipe.title }}</template>
        <template #content>
            <p class="m-0">
                {{ recipe.description }}
            </p>
        </template>
        <template #footer>
            <div class="flex gap-3 mt-1">
                <Button
                    asChild
                    v-slot="slotProps"
                    class="w-full"
                >
                    <RouterLink
                        :to="{ name: 'recipe', params: { slug: recipe.slug }}"
                        :class="slotProps.class"
                    >
                        Let's Cook!
                    </RouterLink>
                </Button>
            </div>
        </template>
    </Card>
</template>
