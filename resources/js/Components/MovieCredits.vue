<template>
  <div class="flex items-center justify-center">
    <div class="w-11/12">
      <div class="font-bold text-white text-xl mb-3">Distribution et équipe technique :</div>
      <Swiper :allowTouchMove="false" :modules="modules" :freeMode="{ sticky: true }" :slides-per-view="getSlidePerViewCredits()"
        :space-between="40" navigation :mousewheel="{ forceToAxis: true, sensitivity: 2 }">
        <swiper-slide class="card swiper-slide" v-for="cast in credits.cast">
          <Link :href="route('person.show', cast.id)">
            <div class="image_content">
              <div class="card_image">
                <img :src="getPortrait(cast.profile_path)" alt="" class="card_img">
              </div>
            </div>
            <div class="card_content">
              <h2 class="name">{{ cast.name }}</h2>
              <p class="description">{{ cast.character }}</p>
            </div>
          </Link>
        </swiper-slide>
      </Swiper>
    </div>
  </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, FreeMode, Mousewheel, A11y } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/mousewheel';
import 'swiper/css/free-mode';

import { Link } from '@inertiajs/vue3';

const modules = [Navigation, FreeMode, Mousewheel, A11y];

defineProps({
  credits: Object
});

function getSlidePerViewCredits() {
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

function getPortrait(img) {
  if (img != null) {
    return 'https://image.tmdb.org/t/p/w200' + img
  }
  return 'https://fr.web.img3.acsta.net/c_162_216/commons/v9/common/empty/empty_portrait.png'
}


</script>

<style scoped>
.image_content,
.card_content {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 10px 14px;
}

.image_content {
  position: relative;
  row-gap: 5px;
  padding: 10px 0;
}

.card_image {
  position: relative;
  height: 150px;
  width: 150px;
  padding: 3px;
}

.card_image .card_img {
  height: 100%;
  width: 100%;
  border-radius: 50%;
  object-fit: cover;
}

.name {
  font-size: 18px;
  font-weight: 500;
  color: #fffbfb;
}

.description {
  font-size: 14px;
  color: #e1e1e1;
  text-align: center;
}

.button {
  border: none;
  font-size: 16px;
  color: #FFF;
  padding: 8px 16px;
  background-color: #4070F4;
  border-radius: 6px;
  margin: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.button:hover {
  background: #265DF2;
}

.swiper-navBtn {
  color: #6E93f7;
  transition: color 0.3s ease;
}

.swiper-navBtn:hover {
  color: #4070F4;
}

.swiper-navBtn::before,
.swiper-navBtn::after {
  font-size: 35px;
}

.swiper-button-next {
  right: 0;
}

.swiper-button-prev {
  left: 0;
}

.swiper-pagination-bullet {
  background-color: #6E93f7;
  opacity: 1;
}

.swiper-pagination-bullet-active {
  background-color: #4070F4;
}

@media screen and (max-width: 768px) {
  .slide-content {
    margin: 0 10px;
  }

  .swiper-navBtn {
    display: none;
  }
}
</style>