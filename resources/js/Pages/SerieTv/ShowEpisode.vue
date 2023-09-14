<template>
  <Head :title="episode.name" />

  <AppLayout :statusCode="episode.statusCode" :statusMessage="episode.statusMessage">
    <div class="pb-6 text-white">
      <EpisodeDetails :episode="episode" />
      <EpisodeCredits :credits="credits" />
    </div>
  </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import EpisodeDetails from '@/Components/EpisodeDetails.vue';
import EpisodeCredits from '@/Components/EpisodeCredits.vue';

const props = defineProps({
  episode: Object,
  credits: Object,
});
</script>

<style scopted></style>