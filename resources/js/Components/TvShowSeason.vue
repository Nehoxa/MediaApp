<template>
  <div class="flex items-center justify-center mt-16 xl:mt-0">
    <div class="w-11/12">
      <div v-if="seasons.length === 1" class="font-bold text-white text-xl mb-3">Saison :</div>
      <div v-if="seasons.length != 1" class="font-bold text-white text-xl mb-3">Saisons :</div>
      <div class="">
        <Swiper :modules="modules" :allowTouchMove="false" :freeMode="{ sticky: true }"
          :slides-per-view="getSlidePerViewSeason()" :space-between="30" navigation
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

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/mousewheel';
import 'swiper/css/free-mode';

const modules = [Navigation, FreeMode, Mousewheel, A11y];

const props = defineProps({
  seasons: Object,
  idTvShow: Number,
});

function getSlidePerViewSeason() {
  const screenWidth = window.innerWidth;

  if (screenWidth >= 1200) {
    return 6;
  } else if (screenWidth >= 700) {
    return 5;
  } else if (screenWidth >= 800) {
    return 4;
  } else if (screenWidth >= 500) {
    return 3;
  } else if (screenWidth >= 300) {
    return 2;
  }
}

function getBackdrop(img) {
  if (img != null) {
    return 'https://image.tmdb.org/t/p/w200' + img;
  }
  return 'https://fr.web.img6.acsta.net/c_200_300/commons/v9/common/empty/empty_portrait.png';
}
</script>

<style lang="scss" scoped></style>