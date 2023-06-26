<template>
  <div class="flex items-center justify-center">
    <div class="w-11/12">
      <div class="font-bold text-white text-xl mb-3">Séries TV :</div>
      <Swiper :modules="modules" :allowTouchMove="false" :freeMode="{ sticky: true }" :slides-per-view="8" :space-between="50" navigation
        :mousewheel="{ forceToAxis: true, sensitivity: 2 }">
        <swiper-slide class="card swiper-slide" v-for="movie in tv_credits.cast">
          <Link :href="route('movie.show', movie.id)">
            <img :src="getBackdrop(movie.poster_path)" alt="" class="rounded-lg w-48 h-64">
            <div class="font-bold text-white mt-3">{{ movie.name }}</div>
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
  tv_credits: Object
});

function getBackdrop(img) {
  if (img != null) {
    return 'https://image.tmdb.org/t/p/w200' + img
  }
  return 'https://fr.web.img6.acsta.net/c_310_420/commons/v9/common/empty/empty_portrait.png'
}

</script>

<style lang="scss" scoped></style>