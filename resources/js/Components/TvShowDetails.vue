<template>
  <!-- <pre class="text-white">{{ serie }}</pre> -->
  <div className="serie">
    <div className="serie__intro">
      <div className="fade"></div>
      <img className="serie__backdrop" :src="'https://image.tmdb.org/t/p/original' + serie.backdropPath" />
    </div>
    <div className="serie__detail">
      <div className="serie__detailLeft">
        <div className="serie__posterBox">
          <img className="serie__poster" :src="'https://image.tmdb.org/t/p/w400' + serie.posterPath" />
        </div>
      </div>
      <div className="serie__detailRight">
        <div className="serie__detailRightTop">
          <div className="serie__hearderContainer">
            <span className="serie__name">{{ serie.name ? serie.name : "" }}</span>
            <span className="serie__status" v-if="getStatus(serie.status) === 'En Cours'">{{ getStatus(serie.status)
            }}</span>
            <span className="serie__finishStatus"
              v-if="getStatus(serie.status) === 'Terminé' || getStatus(serie.status) === 'Annulé'">{{
                getStatus(serie.status) }}</span>
          </div>
          <div className="serie__tagline">{{ serie.tagline ? serie.tagline : '' }}</div>
          <div className="serie__rating">
            <span className="serie__note">{{ parseFloat(serie.voteAverage.toFixed(1)) }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd"
                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                clip-rule="evenodd" />
            </svg>
            <span className="serie__voteCount">{{ serie.voteCount ? "- (" + serie.voteCount + ") votes" : "" }}</span>
          </div>
          <div className="serie__date">
            <div>{{ formatDate(serie.firstAirDate) + ' - ' + formatDate(serie.lastAirDate) }}</div>
            <div v-for="vo in serie.spokenLanguages">Version Original : {{ vo.englishName }}</div>
          </div>
          <div>
            <span className="serie__season">{{ serie.episodeRunTime ? formattedSeason(serie.numberOfSeasons) : ""
            }}</span>
            <span className="serie__eps">{{ serie.episodeRunTime ? formattedEpisode(serie.numberOfEpisodes) : ""
            }}</span>
            <span className="serie__runtime">{{ serie.episodeRunTime.length >= 1 ? formatRuntime(serie.episodeRunTime)
              : ""
            }}</span>
          </div>
          <div className="serie__bottomContainer">
            <div className="serie__genres">
              <span className="serie__genre" v-for="genre in serie.genres" :key="genre.id">{{ genre.name }}</span>
            </div>
            <div className="serie__createdByContainer">
              <div className="serie__createdBy" v-for="creator in serie.createdBy" :key="creator.id">
                <Link :href="route('person.show', creator.id)">{{ creator.name }}</Link>
                <div className="serie__creatorRole">Créatrice / Créateur</div>
              </div>
            </div>
          </div>
        </div>
        <div className="serie__detailRightBottom">
          <div className="synopsisText">Synopsis</div>
          <div class="">{{ serie.overview ? serie.overview : "" }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  serie: Object
});

function formatDate(date) {
  const dateObj = new Date(date);
  const options = { day: 'numeric', month: 'long', year: 'numeric' };
  return dateObj.toLocaleDateString('fr-FR', options);
}

function formatRuntime(runtime) {
  const hours = Math.floor(runtime / 60);
  const remainingMinutes = runtime % 60;

  let formattedTime = '';
  if (hours >= 1) {
    formattedTime += `${hours}h `;
  }
  if (remainingMinutes != 0) {
    formattedTime += `${remainingMinutes}min`;
  }

  return ' • ' + formattedTime;
}

function formattedSeason(number_of_seasons) {
  const season = ''
  if (number_of_seasons === 1) {
    return number_of_seasons + ' Saison'
  } else {
    return number_of_seasons + ' Saisons'
  }
}

function formattedEpisode(number_of_episodes) {
  const season = ''
  if (number_of_episodes === 1) {
    return ' • ' + number_of_episodes + ' Épisode'
  } else {
    return ' • ' + number_of_episodes + ' Épisodes'
  }
}

function getStatus(status) {
  if (status === 'Ended') {
    return 'Terminé'
  } if (status === 'Returning Series') {
    return 'En Cours'
  } if (status === 'Canceled') {
    return 'Annulé'
  }
}


</script>

<style scoped>
.serie {
  width: 100%;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.serie__intro {
  width: 100%;
}

.serie__backdrop {
  width: 100%;
  height: 600px;
  object-fit: cover;
  object-position: 0 35%;
  margin-bottom: 150px;
}

.fade {
  width: 100%;
  height: 400px;
  position: absolute;
  top: 200px;
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(3, 7, 18, 1));
}

.serie__detail {
  align-items: center;
  width: 95%;
  display: flex;
  position: absolute;
  top: 0px;
}

.serie__detailLeft {
  margin-right: 30px;
  display: none;
}

.serie__posterBox {
  flex: 2
}

.serie__poster {
  width: 300px;
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.86) 0px 22px 40px 6px;
}

.serie__detailRight {
  color: white;
  display: flex;
  flex-direction: column;
  height: 450px;
  width: 100%;
}

.serie__detailRightTop>div {
  text-shadow: 0px 0px 5px #000000;
  margin-bottom: .5rem;
}

.serie__hearderContainer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.serie__name {
  font-weight: 600;
  font-size: 3rem;
}

.serie__status {
  font-weight: 300;
  font-size: 1.5rem;
  background-color: rgba(255, 179, 0, 0.444);
  padding: 5px;
  border-radius: 10px;
}

.serie__finishStatus {
  font-weight: 300;
  font-size: 1.5rem;
  background-color: rgba(255, 0, 0, 0.444);
  padding: 5px;
  border-radius: 10px;
}

.serie__rating {
  display: flex;
}

.serie__note {
  margin-right: 5px;
}

.serie__voteCount {
  margin-left: 4px;
}

.serie__date {
  display: flex;
  justify-content: space-between;
}

.serie__bottomContainer {
  display: flex;
  justify-content: space-between;
  align-items: start;
  flex-direction: column;
}

.serie__createdByContainer {
  font-size: 1.5rem;
  display: flex;
}

.serie__createdBy {
  font-weight: bold;
  margin-right: 2rem;
}

.serie__creatorRole {
  font-size: 1rem;
  font-weight: lighter;
}

.serie__genres {
  margin: 1rem 0;
  display: flex;
  flex-direction: column;
}

.serie__genre {
  padding: .5rem;
  border: 2px solid white;
  border-radius: 20px;
  margin-right: 1rem;
  margin-bottom: 10px;
  max-width: fit-content;
  height: fit-content;
}

.serie__detailRightBottom {
  flex: 0.8;
  height: fit-content;
}

.synopsisText {
  font-size: 1.5rem;
  font-weight: 600;
  display: flex;
  position: relative;
  align-items: center;
}

.synopsisText>div:last-of-type {
  margin-left: auto;
}

.serie__links {
  position: relative;
  bottom: 120px;
  display: flex;
  justify-content: space-between;
  width: 75%;
}

.serie__heading {
  font-size: 2.2rem;
}

.serie__Button {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0.8rem 2rem;
  border-radius: 20px;
  cursor: pointer;
  width: 150px;
  color: black;
  font-weight: bold;
}

.serie__homeButton {
  background-color: rgb(255, 0, 0);

}

.serie__imdbButton {
  background-color: #f3ce13;
}

.newTab {
  margin-left: 1.4rem;
}

.serie__production {
  width: 85%;
  display: flex;
  justify-content: center;
  align-items: flex-end;
  margin-bottom: 4rem;
}


.serie__productionComapany {
  width: 200px;
  margin: 2rem;
}

.productionCompanyImage {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

@media (min-width: 1536px) {
  .serie__bottomContainer {
    align-items: center;
    flex-direction: row;
  }

  .serie__createdBy {
    margin-left: 2rem;
    margin-right: 0;
  }
}

@media (min-width: 930px) {
  .serie__detail {
    width: 85%;
    top: 345px;
  }

  .serie__intro {
    width: 90%;
  }

  .serie__backdrop {
    width: 100%;
  }

  .fade {
    width: 90%;
  }

}

@media (min-width: 870px) {
  .serie__detail {
    top: 200px;
  }
}

@media (min-width: 730px) {
  .serie__genres {
    margin: 1.25rem 0;
    flex-direction: row;
  }

  .serie__genre {
    padding: .5rem;
    border: 2px solid white;
    border-radius: 20px;
    margin-right: 1rem;
    margin-bottom: 0;
  }

  .serie__detailLeft {
    display: block;
  }

  .serie__detailRight {
    width: 80%;
  }
}
</style>
