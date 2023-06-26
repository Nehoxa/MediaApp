<template>
  <div class="py-3 w-129 3xl:w-130 pb-20 mx-4">
    <div @click="showMovie(movie.id)"
      class="bg-gray-950 shadow-lg max-h-80 border sm:rounded-3xl p-8 flex space-x-8 hover:shadow-hover">
      <div class="h-48 overflow-visible">
        <img class="rounded-3xl shadow-lg max-w-none" :src="'https://image.tmdb.org/t/p/w200' + movie.poster_path" alt="">
      </div>
      <div class="flex flex-col w-1/2 space-y-4">
        <div class="flex justify-between items-start">
          <h2 class="text-2xl font-bold text-white">{{ movie.title }}</h2>
          <div class="bg-yellow-400 font-bold rounded-xl p-2">{{ movie.vote_average }}</div>
        </div>
        <div>
          <div class="text-white">Date de sortie
            <span class="font-semibold text-white">{{ formatDate(movie.release_date) }}</span>
          </div>
          <div class="flex flex-wrap mt-4">
            <div v-for="genre in movie.genre_ids" :key="genre.id">
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
  movie: Object,
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

function showMovie(id) {
  router.get(route('movie.show', id))
}

</script>