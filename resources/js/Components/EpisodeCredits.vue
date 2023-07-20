<template>
  <div class="flex justify-center">
    <div class="w-11/12 xl:w-10/12 flex flex-col">
      <div>
        <h3 class="text-2xl font-bold ml-6 mb-6">Artistes récurrents de la saison :</h3>
        <div class="flex flex-wrap">
          <Link :href="route('person.show', person.id)" v-for="person in credits.cast" class="w-32 mx-4 my-2">
            <img :src="getPortrait(person.profile_path)" alt="" class="rounded-lg h-48">
            <div class="font-bold my-1 text-lg">{{ person.name }}</div>
            <div class="">{{ person.character }}</div>
          </Link>
        </div>
        <hr class="my-12">
      </div>
      <div>
        <h3 class="text-2xl font-bold ml-6 mb-6">Artistes invités :</h3>
        <div class="flex flex-wrap">
          <Link :href="route('person.show', person.id)" v-for="person in credits.guestStars" class="w-32 mx-4 my-2">
            <img :src="getPortrait(person.profile_path)" alt="" class="rounded-lg h-48">
            <div class="font-bold my-1 text-lg">{{ person.name }}</div>
            <div class="">{{ person.character }}</div>
          </Link>
        </div>
        <hr class="my-12">
      </div>
      <div>
        <h3 class="text-2xl font-bold ml-6 mb-6">Crew :</h3>
        <div class="flex flex-wrap">
          <Link :href="route('person.show', person.id)" v-for="person in credits.crew" class="w-32 mx-4 my-2">
            <img :src="getPortrait(person.profile_path)" alt="" class="rounded-lg h-48">
            <div class="font-bold my-1 text-lg">{{ person.name }}</div>
            <div class="">{{ person.job }}</div>
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  credits: Object
});

function getPortrait(img) {
  if (img != null) {
    return 'https://image.tmdb.org/t/p/w200' + img
  }
  return 'https://fr.web.img3.acsta.net/c_162_216/commons/v9/common/empty/empty_portrait.png'
}

</script>

<style scoped></style>
