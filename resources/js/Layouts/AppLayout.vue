<template>
  <div class="min-h-screen flex flex-col pt-6 sm:pt-0 bg-gray-950">
    <div class="w-full text-white bg-black h-10 font-bold text-xl flex justify-center items-center">
      <div class="w-4/5 flex justify-between">
        <div class="w-44 flex justify-center">
          <Link :href="route('movie.index')">Films</Link>
        </div>
        <div class="w-44 flex justify-center">
          <Link :href="route('movie.home')">Media App</Link>
        </div>
        <div class="w-44 flex justify-center">
          <Link :href="route('serie.index')">Series</Link>
        </div>
        <div class="text-black">
          <div class="input">
            <input @keyup="searchTask" class="h-8 rounded w-full pl-7 relative" type="text" placeholder="Recherche..." v-model="form.search"
              @keyup.enter="submit()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
          </div>
          <div class="bg-white w-cont h-content rounded absolute text-base z-50" v-if="searchResults">
            <Link :href="getLink(result.media_type, result.id)" v-for="result in searchResults.results">
            <div class="flex">
              <div class="w-16">
                <img class="w-full"
                  :src="result.poster_path ? 'https://image.tmdb.org/t/p/w200' + result.poster_path : ''" alt="">
              </div>
              <div class="hover:bg-slate-300 w-full rounded">{{ result.title ? result.title : result.name }}</div>
            </div>
            <hr class="text-black">
            </Link>
            <div class="cursor-pointer" @click="submit()">Voir plus</div>
          </div>
        </div>
      </div>
    </div>
    <slot />
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import axios from 'axios';

const form = useForm({
  search: '',
  page: 1
});

let searchResults = null;

function searchTask() {
  if (form.search.length >= 2) {
    axios.get('https://api.themoviedb.org/3/search/multi?query=' + form.search + '&include_adult=false&api_key=9459b375bf38ce2fed2c530b95f139fa&language=fr-FR&page=1')
      .then(response => {
        searchResults = response.data;
      })
      .catch(error => console.log(error))
  }
  if (form.search.length <= 1) {
    searchResults = null
  }
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


function submit() {
  router.get(route('search', form));
  router.get(route('search'), {
    'search': form.search,
    'page': form.page
  });
}
</script>

<style scoped>
.input {
  width: 12rem;
  position: relative;
}

.input svg {
  width: 20px;
  height: 20px;
  top: 6px;
  left: 6px;
  color: black;
  position: absolute;
}
</style>