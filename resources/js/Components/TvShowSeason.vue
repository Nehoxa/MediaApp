<template>
  <div class="flex items-center justify-center mt-24 md:mt-16 xl:mt-0">
    <div class="w-11/12">
      <div class="font-bold text-white text-xl mb-3">Saisons :</div>
      <div class="">
        <Swiper :modules="modules" :allowTouchMove="false" :freeMode="{ sticky: true }"
          :slides-per-view="getSlidePerView(seasons)" :space-between="30" navigation
          :mousewheel="{ forceToAxis: true, sensitivity: 2 }">
          <swiper-slide class="card swiper-slide" v-for="season in seasons">
            <Link :href="route('serie.showSeason', [idTvShow, season.season_number])">
            <img :src="getBackdrop(season.poster_path)" alt="" class="rounded-lg">
            <div class="text-white mt-3">{{ season.title ? season.title : season.name }}</div>
            </Link>
          </swiper-slide>
        </Swiper>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, FreeMode, Mousewheel, A11y } from 'swiper';
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/mousewheel';
import 'swiper/css/free-mode';

const modules = [Navigation, FreeMode, Mousewheel, A11y];

const props = defineProps({
  seasons: Object,
  idTvShow: Number,
});

function getSlidePerView(seasons) {
  if (seasons.length <= 6) {
    return seasons.length
  } else {
    return 6
  }
}

function getBackdrop(img) {
  if (img != null) {
    return 'https://image.tmdb.org/t/p/w200' + img
  }
  return 'https://fr.web.img6.acsta.net/c_200_300/commons/v9/common/empty/empty_portrait.png'
}
</script>

<style lang="scss" scoped></style>