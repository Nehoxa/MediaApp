<template>
  <Head :title="movie.title" />

  <AppLayout :statusCode="movie.statusCode" :statusMessage="movie.statusMessage">
    <div class="w-full h-full pb-6" v-if="movie.statusCode === 200">
      <MovieDetails :movie="movie" />
      <div>
        <MovieCredits :credits="credits" />
      </div>
      <div>
        <MovieRelated :relatedMovies="relatedMovies" v-if="relatedMovies.results.length != 0" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import MovieDetails from '@/Components/MovieDetails.vue'
import MovieCredits from '@/Components/MovieCredits.vue'
import MovieRelated from '@/Components/MovieRelated.vue';

const props = defineProps({
  movie: Object,
  credits: Object,
  relatedMovies: Object,
});
</script>