<template>
  <AppLayout>
    <div class="w-full h-full pb-6">
      <MovieDetails :movie="movie" />
      <div>
        <MovieCredits :credits="credits" />
      </div>
      <div>
        <MovieRelated :relatedMovies="relatedMovies" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
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