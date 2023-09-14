<template>
  <Head title="Media App" />

  <AppLayout :statusCode="medias.statusCode" :statusMessage="medias.statusMessage">
    <div class="flex flex-wrap pb-6">
      <div v-for="media in medias.results" :key="media.id">
        <CardMovie :movie="media" :genres="genres" v-if="media.media_type === 'movie'" />
        <TvShowCard :serie="media" :genres="genres" v-if="media.media_type === 'tv'" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import CardMovie from '@/Components/CardMovie.vue'
import TvShowCard from '@/Components/TvShowCard.vue'

defineProps({
  medias: Object,
  genres: Object,
  statusMessage: String
});
</script>