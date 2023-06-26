<template>
  <AppLayout>
    <div class="flex flex-wrap pb-6">
      <div v-for="movie in movies.results" :key="movie.id">
        <CardMovie :movie="movie" :genres="genres" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardMovie from '@/Components/CardMovie.vue'


defineProps({
  movies: Object,
  genres: Object,
});
</script>