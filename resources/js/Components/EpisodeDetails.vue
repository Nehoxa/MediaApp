<template>
  <div className="serie">
    <div className="serie__intro">
      <div className="fade"></div>
      <img className="serie__backdrop" :src="'https://image.tmdb.org/t/p/original' + episode.stillPath" />
    </div>
    <div className="serie__detail">
      <div className="serie__detailRight">
        <div className="serie__detailRightTop">
          <div className="serie__hearderContainer">
            <span className="serie__name">{{ episode.name ? episode.name : "" }}</span>
          </div>
          <div className="serie__rating">
            <span className="serie__note">{{ episode.voteAverage.toFixed(1) }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd"
                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                clip-rule="evenodd" />
            </svg>
            <span className="serie__voteCount">{{ episode.voteCount ? "- (" + episode.voteCount + ") votes" : ""
            }}</span>
          </div>
          <div className="serie__date">
            <div>{{ episode.airDate ? formatDate(episode.airDate) : '' }}</div>
          </div>
          <div>
            <span className="serie__eps">{{ episode.episodeNumber ? 'Saison ' + episode.episodeNumber : ""
            }}</span>
            <span className="serie__season">{{ episode.seasonNumber ? ' • Épisode ' + episode.seasonNumber : ""
            }}</span>
            <span className="serie__runtime">{{ episode.runtime ? formatRuntime(episode.runtime) : ""
            }}</span>
          </div>
        </div>
        <div className="serie__detailRightBottom">
          <div className="synopsisText">Synopsis</div>
          <div class="">{{ episode.overview ? episode.overview : "" }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

defineProps({
  episode: Object
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

</script>

<style scoped>
.serie {
  width: 100%;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  color: white;
}

.serie__intro {
  width: 100%;
}

.serie__backdrop {
  width: 100%;
  height: 600px;
  object-fit: cover;
  object-position: 0 35%;
  margin-bottom: 300px;
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
  top: 475px;
}

.serie__detailLeft {
  margin-right: 30px;
}

.serie__detailRight {
  color: white;
  display: flex;
  flex-direction: column;
  height: 450px;
  width: 80%;
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

@media (min-width: 930px) {
  .serie__detail {
    width: 85%;
  }

  .serie__intro {
    width: 90%;
  }

  .fade {
    width: 90%;
  }
}
</style>
