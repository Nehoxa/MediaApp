<template>
  <AppLayout>
    <div class="flex flex-wrap pb-6">
      <div v-for="media in medias.results" :key="media.id">
        <CardMovie :movie="media" :genres="genres" v-if="media.media_type === 'movie'" />
        <TvShowCard :serie="media" :genres="genres" v-if="media.media_type === 'tv'" />
      </div>
      <div v-if="statusMessage" class="text-white text-3xl flex justify-center mt-32">
        {{ statusMessage }}
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardMovie from '@/Components/CardMovie.vue'
import TvShowCard from '@/Components/TvShowCard.vue'


defineProps({
  medias: Object,
  genres: Object,
  statusMessage: String
});
</script>