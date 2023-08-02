<template>
  <!-- <pre class="text-white">{{ movie }}</pre> -->
  <div className="movie">
    <div className="movie__intro">
      <div className="fade"></div>
      <img className="movie__backdrop" :src="'https://image.tmdb.org/t/p/original' + movie.backdropPath" />
    </div>
    <div className="movie__detail">
      <div className="movie__detailLeft">
        <div className="movie__posterBox">
          <img className="movie__poster" :src="'https://image.tmdb.org/t/p/w400' + movie.posterPath" />
        </div>
      </div>
      <div className="movie__detailRight">
        <div className="movie__detailRightTop">
          <div className="movie__name">{{ movie.title }}</div>
          <div className="movie__tagline">{{ movie.tagline ? movie.tagline : '' }}</div>
          <div className="movie__rating">
            <span className="movie__note">{{ parseFloat(movie.voteAverage.toFixed(1)) }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd"
                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                clip-rule="evenodd" />
            </svg>
            <span className="movie__voteCount">{{ movie.voteCount ? "- (" + movie.voteCount + ") votes" : "" }}</span>
          </div>
          <div className="movie__runtime">{{ movie.runtime ? formatRuntime(movie.runtime) : "" }}</div>
          <div className="movie__releaseDate">Sorti le {{ formatDate(movie.releaseDate) }}</div>
          <div className="movie__genres">
            <span className="movie__genre" v-for="genre in movie.genres" :key="genre.id">{{ genre.name }}</span>
          </div>
        </div>
        <div className="movie__collection" v-if="movie.belongsToCollection">
          <Link :href="route('movie.showCollection', movie.belongsToCollection.id)">{{ movie.belongsToCollection ?
            movie.belongsToCollection.name : '' }}</Link>
        </div>
        <div className="movie__detailRightBottom">
          <div className="synopsisText">Synopsis</div>
          <div class="">{{ movie.overview }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  movie: Object
});

function formatDate(date) {
  const dateObj = new Date(date);
  const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
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

  return formattedTime;
}

</script>

<style scoped>
.movie {
  width: 100%;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.movie__intro {
  width: 100%;
}

.movie__backdrop {
  width: 100%;
  height: 600px;
  object-fit: cover;
  object-position: 0 35%;
  margin-bottom: 300px;
}

.fade {
  width: 100%;
  height: 300px;
  position: absolute;
  top: 300px;
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(3, 7, 18, 1));
}

.movie__detail {
  align-items: center;
  width: 95%;
  display: flex;
  position: absolute;
  top: 250px;
}

.movie__detail__notagline {
  align-items: center;
  width: 95%;
  display: flex;
  position: absolute;
  top: 100px;
}

.movie__detailLeft {
  margin-right: 30px;
  display: none;
}

.movie__posterBox {
  flex: 2
}

.movie__poster {
  width: 300px;
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.86) 0px 22px 40px 6px;
}

.movie__detailRight {
  color: white;
  display: flex;
  flex-direction: column;
  height: 450px;
  width: 100%;
}

.movie__detailRightTop>div {
  text-shadow: 0px 0px 5px #000000;
  margin-bottom: .5rem;
}

.movie__name {
  font-weight: 600;
  font-size: 3rem;
}

.movie__rating {
  display: flex;
}

.movie__note {
  margin-right: 5px;
}

.movie__voteCount {
  margin-left: 4px;
}

.movie__genres {
  margin: 1.25rem 0;
}

.movie__genre {
  padding: .5rem;
  border: 2px solid white;
  border-radius: 20px;
  margin-right: 1rem;
  max-width: fit-content;
  height: fit-content;
}

.movie__collection {
  font-weight: 600;
  font-size: x-large;
  margin-top: 1rem;
}

.movie__detailRightBottom {
  flex: 0.8;
  height: fit-content;
}

.synopsisText {
  font-size: 1.5rem;
  margin-top: 0.5rem;
  font-weight: 600;
  display: flex;
  position: relative;
  align-items: center;
}

.synopsisText>div:last-of-type {
  margin-left: auto;
}

.movie__links {
  position: relative;
  bottom: 120px;
  display: flex;
  justify-content: space-between;
  width: 75%;
}

.movie__heading {
  font-size: 2.2rem;
}

.movie__Button {
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

.movie__homeButton {
  background-color: rgb(255, 0, 0);

}

.movie__imdbButton {
  background-color: #f3ce13;
}

.newTab {
  margin-left: 1.4rem;
}

.movie__production {
  width: 85%;
  display: flex;
  justify-content: center;
  align-items: flex-end;
  margin-bottom: 4rem;
}


.movie__productionComapany {
  width: 200px;
  margin: 2rem;
}

.productionCompanyImage {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

@media (min-width: 930px) {
  .movie__detail {
    width: 85%;
  }

  .movie__detail__notagline {
    width: 85%;
  }

  .movie__intro {
    width: 90%;
  }

  .fade {
    width: 90%;
  }
}

@media (min-width: 730px) {
  .movie__detailLeft {
    display: block;
  }

  .movie__detailRight {
    width: 80%;
  }
}

@media (min-width: 500px) {
  .movie__detail {
    top: 345px;
  }
}
</style>
