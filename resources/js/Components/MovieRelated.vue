<template>
  <div class="flex items-center justify-center">
    <div class="w-11/12">
      <div class="font-bold text-white text-xl mb-3">Recommandation :</div>
      <Swiper :modules="modules" :allowTouchMove="false" :freeMode="{ sticky: true }" :slides-per-view="5" :space-between="50" navigation
        :mousewheel="{ forceToAxis: true, sensitivity: 2 }">
        <swiper-slide class="card swiper-slide" v-for="movie in relatedMovies.results">
          <Link :href="route('movie.show', movie.id)">
            <img :src="getBackdrop(movie.backdrop_path)" alt="" class="card-img rounded-lg">
            <div class="font-bold text-white mt-3">{{ movie.title }}</div>
          </Link>
        </swiper-slide>
      </Swiper>
    </div>
  </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, FreeMode, Mousewheel, A11y } from 'swiper';
import { Link } from '@inertiajs/vue3';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/mousewheel';
import 'swiper/css/free-mode';

const modules = [Navigation, FreeMode, Mousewheel, A11y];

const props = defineProps({
  relatedMovies: Object
});

function getBackdrop(img) {
  if (img != null) {
    return 'https://image.tmdb.org/t/p/w400' + img
  }
  return 'https://pprime.fr/wp-content/uploads/psc_post_slider_carousel/no-image-available-grid_218_388.jpg'
}

</script>

<style lang="scss" scoped></style>