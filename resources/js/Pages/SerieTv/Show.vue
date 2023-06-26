<template>
  <AppLayout>
    <div class="w-full h-full pb-6">
      <div v-if="!statusMessage">
        <TvShowDetails :serie="serie" />
        <TvShowSeason :idTvShow="serie.id" :seasons="serie.seasons" />
        <TvShowCredits :credits="credits" v-if="credits.cast.length > 0" />
        <TvShowRelated :recommendations="recommendations" />
      </div>
      <div v-if="statusMessage" class="text-white text-3xl flex justify-center mt-32">
        {{ statusMessage }}
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TvShowDetails from '@/Components/TvShowDetails.vue'
import TvShowSeason from '@/Components/TvShowSeason.vue'
import TvShowCredits from '@/Components/TvShowCredits.vue'
import TvShowRelated from '@/Components/TvShowRelated.vue'

const props = defineProps({
  serie: Object,
  credits: Object,
  recommendations: Object,
  statusMessage: String,
});
</script>