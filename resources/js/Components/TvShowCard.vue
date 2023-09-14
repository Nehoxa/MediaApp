<template>
  <div class="py-3 w-screen sm:w-129 3xl:w-130 sm:pb-20 sm:mx-4">
    <div @click="showMovie(serie.id)"
      class="bg-gray-950 hover:bg-gradient-to-b from-gray-950 to-gray-700 shadow-lg cursor-pointer max-h-80 sm:rounded-3xl p-8 flex space-x-8">
      <div class="h-48 overflow-visible">
        <img class="rounded-3xl shadow-lg w-36 sm:w-auto" :src="'https://image.tmdb.org/t/p/w200' + serie.poster_path" alt="">
      </div>
      <div class="flex flex-col w-1/2 space-y-4">
        <div class="flex justify-between items-start">
          <h2 class="text-2xl font-bold text-white">{{ serie.name }}</h2>
          <div class="bg-yellow-400 font-bold rounded-xl p-2">{{ serie.vote_average ? parseFloat(serie.vote_average.toFixed(1)) : '' }}</div>
        </div>
        <div>
          <div class="text-white">Date de sortie
            <span class="font-semibold text-white">{{ formatDate(serie.first_air_date) }}</span>
          </div>
          <div class="flex flex-wrap mt-4">
            <div v-for="genre in serie.genre_ids" :key="genre.id">
              <span class="text-indigo-400 font-bold mr-2">{{ getGenre(genre) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  serie: Object,
  genres: Object,
});

function getGenre(id) {
  const genre = props.genres.genres.find((genre) => genre.id === id);
  return genre ? genre.name : '';
}

function formatDate(date) {
  const unformatDate = new Date(date);
  const day = unformatDate.getDate();
  const month = unformatDate.toLocaleString('fr-FR', { month: 'long' });
  const year = unformatDate.getFullYear();

  const formattedDate = `${day} ${month} ${year}`;
  return formattedDate;
}

function formatNote() {
  
}

function showMovie(id) {
  router.get(route('serie.show', id))
}

</script>