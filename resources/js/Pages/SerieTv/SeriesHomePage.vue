<template>
  <AppLayout>
    <div class="flex flex-wrap pb-6">
      <div v-for="serie in series.results" :key="serie.id">
        <!-- <pre class="text-white">{{ serie }}</pre> -->
        <TvShowCard :serie="serie" :genres="genres" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TvShowCard from '@/Components/TvShowCard.vue'


defineProps({
  series: Object,
  genres: Object,
  tvseries: Object,
});
</script>