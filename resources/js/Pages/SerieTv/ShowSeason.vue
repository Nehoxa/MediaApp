<template>
  <Head :title="season.name"/>

  <AppLayout :statusCode="season.statusCode" :statusMessage="season.statusMessage">
    <div class="w-full h-full pb-6 text-white">
      <div class="flex justify-center">
        <div class="flex flex-col lg:flex-row w-4/5 items-center">
          <img class="h-150 rounded-b-lg" :src="'https://image.tmdb.org/t/p/original' + season.posterPath" />
          <div class="mt-8 lg:ml-6 lg:mt-0 flex flex-col items-center lg:items-start">
            <h1 class="text-7xl font-bold">{{ season.seasonNumber ? 'Saison ' + season.seasonNumber : season.name }}</h1>
            <div class="mt-6">{{ season.airDate ? 'Sorti le ' + formatDate(season.airDate) : '' }}</div>
          </div>
        </div>
      </div>
      <div class="mt-4 text-lg flex justify-center">
        <p class="w-4/5 mt-4">{{ season.overview }}</p>
      </div>
      <Link :href="route('serie.showEpisode', [episode.show_id, episode.season_number, episode.episode_number])"
        v-for="episode in season.episodes" :key="episode.id"
        class="flex-none justify-center xl:flex xl:justify-start m-16">
      <img class="h-115 rounded-lg m-6 xl:mx-0" :src="'https://image.tmdb.org/t/p/original' + episode.still_path"
        v-if="episode.still_path" />
      <div class="mx-6 xl:mr-0 flex items-center">
        <div>
          <h1 class="font-bold text-5xl">{{ episode.name }}</h1>
          <div class="mt-4">{{ episode.episode_number ? 'Épisode : ' + episode.episode_number : '' }}</div>
          <div class="mb-4">{{ episode.air_date ? 'Sortie le : ' + formatDate(episode.air_date) : '' }}</div>
          <div class="mb-4 text-lg">{{ episode.overview }}</div>
          <div class="">{{ episode.runtime ? 'Durée : ' + formatRuntime(episode.runtime) : '' }}</div>
          <div class="flex">
            <span class="mr-1">{{ episode.vote_average }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd"
                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                clip-rule="evenodd" />
            </svg>
            <span class="ml-1">{{ episode.vote_count ? " - (" + episode.vote_count + ") votes" : "" }}</span>
          </div>
        </div>
      </div>
      </Link>
    </div>
  </AppLayout>
</template>

<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({
  season: Object,
});

function formatDate(date) {
  const dateObj = new Date(date);
  const options = { day: 'numeric', month: 'long', year: 'numeric' };
  return dateObj.toLocaleDateString('fr-FR', options);
}

function formatRuntime(runtime) {
  const hours = Math.floor(runtime / 60);
  const remainingMinutes = runtime % 60;

  let formattedTime = '';
  if (hours >= 1) {
    formattedTime += `${hours}h `;
  }
  if (remainingMinutes != 0) {
    formattedTime += `${remainingMinutes}min`;
  }

  return formattedTime;
}


</script>

<style scopted></style>