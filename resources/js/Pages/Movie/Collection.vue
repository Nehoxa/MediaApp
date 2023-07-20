<template>
  <AppLayout :statusCode="collection.statusCode" :statusMessage="collection.statusMessage" >
    <div class="pb-6">
      <div className="collection">
        <div className="collection__intro">
          <div className="fade"></div>
          <img className="collection__backdrop" :src="'https://image.tmdb.org/t/p/original' + collection.backdropPath" />
          <div className="collection__detail">
            <div className="collection__detailLeft">
              <div className="collection__posterBox">
                <img className="collection__poster" :src="'https://image.tmdb.org/t/p/w400' + collection.posterPath" />
              </div>
            </div>
            <div className="collection__detailRight">
              <div className="collection__detailRightTop">
                <div className="collection__name">{{ collection.name }}</div>
                <div className="collection__runtime">{{ collection.runtime ? formatRuntime(collection.runtime) : "" }}</div>
              </div>
              <div className="collection__detailRightBottom">
                <div className="synopsisText">Synopsis</div>
                <div class="">{{ collection.overview }}</div>
              </div>
            </div>
          </div>
        </div>
        <div className="body" v-for="movie in collection.parts">
          <CollectionCard :movie="movie" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import CollectionCard from '@/Components/CollectionCard.vue';
import AppLayout from '@/Layouts/AppLayout.vue';


defineProps({
  collection: Object,
  statusMessage: String
});

</script>

<style scoped>
.collection {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.body {
  width: 90%;
  display: flex;
  flex-direction: column;
}

.collection__intro {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.collection__backdrop {
  width: 100%;
  height: 600px;
  object-fit: cover;
  object-position: 0 35%;
  margin-bottom: 200px;
}

.fade {
  width: 100%;
  height: 225px;
  position: absolute;
  top: 415px;
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(3, 7, 18, 1));
}

.collection__detail {
  align-items: center;
  width: 75%;
  display: flex;
  position: absolute;
  top: 0px;
}

.collection__detailLeft {
  margin-right: 30px;
  display: none;
}

.collection__posterBox {
  flex: 2
}

.collection__poster {
  width: 300px;
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.86) 0px 22px 40px 6px;
}

.collection__detailRight {
  color: white;
  display: flex;
  flex-direction: column;
  height: 450px;
}

.collection__detailRightTop>div {
  text-shadow: 0px 0px 5px #000000;
  margin-bottom: .5rem;
}

.collection__name {
  font-weight: 600;
  font-size: 3rem;
  margin-top: 11rem;
}

.collection__detailRightBottom {
  flex: 0.8;
  max-width: 1000px;
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

.collection__links {
  position: relative;
  bottom: 120px;
  display: flex;
  justify-content: space-between;
  width: 75%;
}

@media (min-width: 400px) {

  .collection__detail {
    top: 100px;
  }
}

@media (min-width: 650px) {

  .collection__detail {
    top: 200px;
  }
}

@media (min-width: 750px) {
  
  .collection__detail {
    top: 300px;
  }

  .collection__detailLeft {
    display: block;
  }

  .collection__intro {
    width: 90%;
  }

  .fade {
    width: 90%;
  }
}

@media (min-width: 1350px) {
  .body {
    margin-top: 100px;
  }

}
</style>