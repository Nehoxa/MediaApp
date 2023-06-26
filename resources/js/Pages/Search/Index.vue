<template>
  <AppLayout>
    <div class="flex flex-col w-full items-center text-white">
      <div class="max-w-screen-2x text-xl mt-8 p-2 border-2 rounded-lg">
        <Link :href="route('search', data)" class="m-6 p-2 bg-white text-black rounded">Tous</Link>
        <Link :href="route('search.movie', data)" class="m-6 p-2">Film</Link>
        <Link :href="route('search.serie', data)" class="m-6 p-2">Serie</Link>
        <Link :href="route('search.person', data)" class="m-6 p-2">Personne</Link>
      </div>
      <div class="flex flex-col items-start m-8 max-w-screen-2xl">
        <div class="w-full flex justify-center">
          <Pagination class="m-2 p-2 flex justify-center" :links="links" v-if="results.total_pages != 1" />
        </div>
        <Link :href="getLink(result.media_type, result.id)" v-for="result in results.results" :key="result.id"
          class="mb-8 flex hover:bg-gradient-to-b from-gray-950 to-gray-700 cursor-pointer w-full rounded-xl">
        <div v-if="result.media_type === 'movie' || result.media_type === 'tv'" class="flex">
          <img class="h-40 shadow-lg max-w-none rounded-l-xl" :src="getPoster(result.poster_path)" alt="">
          <div class="ml-4">
            <div class="flex text-xl">
              <div class="font-bold hover:text-gray-300 mr-2">{{ result.title ? result.title : result.name }}</div>
              <div class="text-slate-500">{{ result.media_type ? '- ' + getType(result.media_type) : '' }}</div>
            </div>
            <div class="mb-3 text-gray-300">{{ result.release_date ? formatDate(result.release_date) : '' }}</div>
            <div>{{ result.overview ? result.overview : '' }}</div>
            <div class="flex mt-3">
              <span class="mr-1">{{ parseFloat(result.vote_average.toFixed(1)) }}</span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd"
                  d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                  clip-rule="evenodd" />
              </svg>
              <span>{{ result.vote_count ? "- (" + result.vote_count + ") votes" : "" }}</span>
            </div>
          </div>
        </div>

        <div v-if="result.media_type === 'person' || result.media_type === 'production'" class="flex">
          <img class="h-40 shadow-lg max-w-none rounded-l-xl" :src="getPoster(result.profile_path)" alt="">
          <div class="ml-4">
            <Link :href="getLink(result.media_type, result.id)" class="text-xl font-bold hover:text-gray-300">{{
              result.name ? result.name :
              '' }}</Link>
            <div class="mb-3 text-gray-300">{{ result.known_for_department ? result.known_for_department : '' }}</div>
            <span v-if="result.known_for.length > 0">Connu(e) pour : </span>
            <Link class="hover:text-gray-300" :href="getLink(project.media_type, project.id)"
              v-for="project in result.known_for" :key="project.id">{{
                project.title ? project.title + ' / ' : project.name + ' / ' }}</Link>
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

function getType(mediaType) {
  if (mediaType === 'movie') {
    return 'Film'
  } else if (mediaType === 'tv') {
    return 'Série'
  } else {
    return ''
  }
}
</script>

<style lang="scss" scoped></style>