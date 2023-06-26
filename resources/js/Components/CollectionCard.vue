<template>
  <div className="card">
    <div className="movie">
      <div className="posterBox">
        <img className="poster" :src="'https://image.tmdb.org/t/p/original' + movie.poster_path" alt="">
      </div>
      <div className="info">
        <div className="title">{{ movie.title }}</div>
        <div className="overview">{{ movie.overview }}</div>
        <div className="date">{{ movie.release_date ? formatDate(movie.release_date) : '' }}</div>
        <div className="rating">
          <span className="note">{{ movie.vote_average.toFixed(1) }}</span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path fill-rule="evenodd"
              d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
              clip-rule="evenodd" />
          </svg>
          <span className="voteCount">{{ movie.vote_count ? "- (" + movie.vote_count + ") votes" : "" }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  movie: Object,
});

function formatDate(date) {
  const dateObj = new Date(date);
  const options = { day: 'numeric', month: 'long', year: 'numeric' };
  return dateObj.toLocaleDateString('fr-FR', options);
}
</script>

<style scoped>
.card {
  color: white;
  margin-bottom: 3rem;
}

.movie {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.posterBox {
  max-width: 250px;
  margin-right: 2rem;
}

.poster {
  border-radius: 10px;
}

.info {
  width: 70%;
}

.title {
  font-size: 25px;
  font-weight: 600;
  margin-bottom: 1rem;
}

.overview {
  margin-bottom: 1rem;
}

.date {
  margin-bottom: 1rem;
}

.rating {
  display: flex;
}

.note {
  margin-right: 0.5rem;
}

.voteCount {
  margin-left: 0.5rem;
}

@media (min-width: 650px) {
  .movie {
    flex-direction: row;
  }
}

</style>