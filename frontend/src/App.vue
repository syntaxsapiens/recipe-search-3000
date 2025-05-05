<script setup>
import { RouterView } from 'vue-router';
</script>

<template>
    <header class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:pt-16 lg:pb-4">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Recipe Search 3000</h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">Home of well seasoned searches!</p>
        </div>
    </header>
  <main class="container mx-auto p-8">
    <RouterView />
  </main>
</template>
