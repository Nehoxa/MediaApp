<template>
  <div class="flex items-center justify-center mt-16">
    <div class="w-11/12">
      <div class="font-bold text-white text-xl mb-3">Populaire :</div>
      <Swiper :modules="modules" :allowTouchMove="false" :freeMode="{ sticky: true }" :slides-per-view="7" :space-between="50" navigation
        :mousewheel="{ forceToAxis: true, sensitivity: 2 }">
        <swiper-slide class="card swiper-slide" v-for="media in popularMedia">
          <Link :href="route('movie.show', media.id)" v-if="media.media_type === 'movie'" class="">
            <img :src="getBackdrop(media.poster_path)" alt="" class="rounded-lg max-h-64">
            <div class="text-white mt-3">{{ media.title ? media.title : media.name }}</div>
          </Link>
          <Link :href="route('serie.show', media.id)" v-if="media.media_type === 'tv'" class="">
            <img :src="getBackdrop(media.poster_path)" alt="" class="rounded-lg max-h-64">
            <div class="text-white mt-3">{{ media.title ? media.title : media.name }}</div>
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
  popularMedia: Object
});

function getBackdrop(img) {
  if (img != null) {
    return 'https://image.tmdb.org/t/p/original' + img
  }
  return 'https://fr.web.img6.acsta.net/c_310_420/commons/v9/common/empty/empty_portrait.png'
}

</script>

<style lang="scss" scoped></style>