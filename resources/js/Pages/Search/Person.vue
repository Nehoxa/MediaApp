<template>
  <Head :title="data.search" />

  <AppLayout :statusCode="results.statusCode" :statusMessage="results.statusMessage">
    <div class="flex flex-col w-full items-center text-white">
      <div class="max-w-screen-2x text-xl mt-8 p-2 border-2 rounded-lg">
        <Link :href="route('search', data)" class="m-8">Tous</Link>
        <Link :href="route('search.movie', data)" class="m-8">Film</Link>
        <Link :href="route('search.serie', data)" class="m-8">Serie</Link>
        <Link :href="route('search.person', data)" class="m-6 p-2 bg-white text-black rounded">Personne</Link>
      </div>
      <div class="flex flex-col items-start m-8 max-w-screen-2xl">
        <div class="w-full flex justify-center">
          <Pagination class="m-2 p-2 flex justify-center" :links="links" v-if="results.total_pages != 1" />
        </div>
        <Link :href="getLink(result.media_type, result.id)" v-for="result in results.results" :key="result.id"
          class="mb-8 flex hover:bg-gradient-to-b from-gray-950 to-gray-700 w-full rounded-xl">
        <img class="h-40 shadow-lg max-w-none rounded-l-xl" :src="getPoster(result.profile_path)" alt="">
        <div class="ml-4">
          <div class="text-xl font-bold hover:text-gray-300">{{ result.name ? result.name : '' }}</div>
          <div class="mb-3 text-gray-300">{{ result.known_for_department ? result.known_for_department : '' }}</div>
          <span v-if="result.known_for.length > 0">Connu(e) pour : </span>
          <Link :href="getLink(project.media_type, project.id)" v-for="project in result.known_for" :key="project.id"
            class="hover:text-gray-300">{{
              project.title ? project.title + ' / ' : project.name + ' / ' }}</Link>
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
import { Link, Head } from '@inertiajs/vue3';
import Pagination from '../../Components/Pagination.vue'

defineProps({
  results: Object,
  links: Object,
  data: Object
});

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
</script>

<style lang="scss" scoped></style>