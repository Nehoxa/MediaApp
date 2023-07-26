<template>
  <AppLayout :statusCode="person.statusCode" :statusMessage="person.statusMessage" >
    <div class="w-full h-full text-white" v-if="person.statusCode === 200">
      <div className="fade"></div>
      <div className="details">
        <div className="image_content">
          <img className="image" :src="person.profilePath ? 'https://image.tmdb.org/t/p/w200' + person.profilePath : ''" alt="">
        </div>
        <div className="name">{{ person.name }}</div>
        <div className="department">Métier : {{ person.knownForDepartment }}</div>
        <div className="birthday">Naissance : {{ formatDate(person.birthday) }}</div>
        <div className="birthday">Lieu de naissance : {{ person.placeOfBirth }}</div>
        <div className="birthday">{{ 'Âge : ' + getOld(person.birthday, person.deathday) + ' ans' }}</div>
        <div className="birthday"> {{ person.deathday ? 'Décès : ' + formatDate(person.deathday) : '' }}</div>
        <div className="biography" v-if="person.biography">
          <span className="biographyTitle">Biographie :</span>
          {{ person.biography }}
        </div>
      </div>
      <PersonMediaPopular :popularMedia="allMedia.popularMedia" v-if="allMedia.popularMedia.length >= 1" />
      <CastComponent :cast="allMedia.cast" v-if="allMedia.cast.length >= 1" />
      <DirectingComponent :directing="allMedia.directing" v-if="allMedia.directing.length >= 1" />
      <ProductionComponent :production="allMedia.production" v-if="allMedia.production.length >= 1" />
      <WritingComponent :writing="allMedia.writing" v-if="allMedia.writing.length >= 1" />
      <CreatorComponent :creator="allMedia.creator" v-if="allMedia.creator.length >= 1" />
    </div>
    <div v-if="statusMessage" class="text-white text-3xl flex justify-center mt-32">
      {{ statusMessage }}
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PersonMediaPopular from '@/Components/PersonMediaPopular.vue';
import CastComponent from '@/Components/CastComponent.vue';
import DirectingComponent from '@/Components/DirectingComponent.vue';
import ProductionComponent from '@/Components/ProductionComponent.vue';
import WritingComponent from '@/Components/WritingComponent.vue';
import CreatorComponent from '@/Components/CreatorComponent.vue';
import { differenceInYears } from 'date-fns';

defineProps({
  person: Object,
  allMedia: Object,
  statusMessage: String
});

function formatDate(date) {
  const dateObj = new Date(date);
  const options = { day: 'numeric', month: 'long', year: 'numeric' };
  return dateObj.toLocaleDateString('fr-FR', options);
}

function getOld(birth, death) {
  const birthdate = new Date(birth)
  
  if (death) {
    const deathdate = new Date(death)
    const age = differenceInYears(deathdate, birthdate)
    return age
  }
  const today = new Date();
  const age = differenceInYears(today, birthdate)
  return age
}


</script>

<style scoped>
.fade {
  width: 100%;
  height: 400px;
  top: 0px;
  position: absolute;
  background: linear-gradient(to bottom, rgba(255, 255, 255, 0.099), rgba(3, 7, 18, 1));
  z-index: -1;
}

.details {
  display: flex;
  flex-direction: column;
  align-items: center;
  z-index: auto;
}

.details>div {
  margin-bottom: 0.5rem;
}

.image_content {
  height: 200px;
  width: 200px;
  display: flex;
  margin-top: 2rem;
}

.image {
  height: 100%;
  width: 100%;
  border-radius: 50%;
  object-fit: cover;
}

.name {
  font-size: 2.5rem;
}

.department {
  font-size: 1.5rem;
}

.birthday {
  font-size: 1.5rem;
}

.biography {
  margin-top: 2rem;
  width: 80%;
  display: flex;
  flex-direction: column;
}

.biographyTitle {
  font-size: 2rem;
  margin-bottom: 0.5rem;
}
</style>