<template>
  <AppLayout :statusCode="results.statusCode" :statusMessage="results.statusMessage" >
    <div class="flex flex-col w-full items-center text-white">
      <div class="max-w-screen-2x text-xl mt-8 p-2 border-2 rounded-lg">
        <Link :href="route('search', data)" class="m-8">Tous</Link>
        <Link :href="route('search.movie', data)" class="m-6 p-2 bg-white text-black rounded">Film</Link>
        <Link :href="route('search.serie', data)" class="m-8">Serie</Link>
        <Link :href="route('search.person', data)" class="m-8">Personne</Link>
      </div>
      <div class="flex flex-col items-start m-8 max-w-screen-2xl">
        <div class="w-full flex justify-center">
          <Pagination class="m-2 p-2 flex justify-center" :links="links" v-if="results.total_pages != 1" />
        </div>
        <Link :href="getLink(result.media_type, result.id)" v-for="result in results.results" :key="result.id"
          class="mb-8 flex hover:bg-gradient-to-b from-gray-950 to-gray-700 cursor-pointer w-full rounded-xl">
        <img class="h-40 shadow-lg max-w-none rounded-l-xl" :src="getPoster(result.poster_path)" alt="">
        <div class="ml-4">
          <div class="text-xl font-bold hover:text-gray-300">{{ result.title ? result.title : result.name }}</div>
          <div class="mb-3 text-gray-300">{{ result.release_date ? formatDate(result.release_date) : '' }}</div>
          <div>{{ result.overview ? formatedOverview(result.overview, 380) : '' }}</div>
          <div class="flex mt-3">
            <span class="mr-1">{{ result.vote_average ? parseFloat(result.vote_average.toFixed(1)) : '' }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5" v-if="result.vote_average">
              <path fill-rule="evenodd"
                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                clip-rule="evenodd" />
            </svg>
            <span>{{ result.vote_count ? "- (" + result.vote_count + ") votes" : "" }}</span>
          </div>

        </div>
        </Link>
        <div class="text-xl font-bold mt-12" v-if="results.results.length === 0">
          Aucun resultat trouvé
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Pagination from '../../Components/Pagination.vue'

defineProps({
  results: Object,
  links: Object,
  data: Object
});

function formatDate(date) {
  const dateObj = new Date(date);
  const options = { day: 'numeric', month: 'long', year: 'numeric' };
  return dateObj.toLocaleDateString('fr-FR', options);
}

function getPoster(img) {
  if (img != null) {
    return 'https://image.tmdb.org/t/p/w200' + img
  }
  return 'https://fr.web.img3.acsta.net/c_200_300/commons/v9/common/empty/empty_portrait.png'
}

function getLink(mediaType, id) {
  if (mediaType === 'movie') {
    return route('movie.show', id)
  } else if (mediaType === 'tv') {
    return route('serie.show', id)
  } else {
    return route('person.show', id)
  }
}

function formatedOverview(overview, maxCharacters) {
  if (overview.length <= maxCharacters) {
    return overview;
  } else {
    let shortenedText = overview.slice(0, maxCharacters);
    const lastSpaceIndex = shortenedText.lastIndexOf(" ");
    if (lastSpaceIndex !== -1) {
      shortenedText = shortenedText.slice(0, lastSpaceIndex);
    }
    return shortenedText + "...";
  }
}

</script>

<style lang="scss" scoped></style>