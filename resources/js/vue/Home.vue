<template>
  <div class="container">
    <div class="d-flex justify-content-between mt-5">
      <h3>Albums</h3>
      <input type="text" v-on:keyup="getSearch">
      <select v-on:change="getDate">
        <option value="">-- date --</option>
        <option v-for="date in dates" :key="date.date_release">{{ new Date(date.date_release).getFullYear() }}</option>
      </select>
      <router-link class="btn btn-primary" :to="{ name: 'Create' }">Add new Album</router-link>
    </div>
    <hr>

    <div class="cards row">
      <div class="col-4 mb-3" v-for="album in albums.data" :key="album.id">
        <div class="card" style="width: 18rem;" v-on:mouseenter="mouseEnter" v-on:mouseleave="mouseLeave">
          <div :class="{ hovered: hovered }">
            <router-link :to="{name: 'Show', params: {id: album.id}}">
              <img :src="album.cover" class="card-img-top" alt="...">
              <div class="card-img-overlay border d-flex align-items-center justify-content-center mt-0">
                <p>see details</p>
              </div>
            </router-link>
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ album.title }}</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-3">
      <Bootstrap5Pagination
        :data="albums"
        @pagination-change-page="getAlbums"
        align="center"
        size="large"
      />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

export default {
  name: 'Home',
  components: {
    Bootstrap5Pagination
  },
  data(){
    return{
      hovered: false,
      albums: {},
      dates: {},
      searchQuery: '',
      dateQuery: ''
    }
  },
  mounted(){
    this.getAlbums()
  },
  methods:{
    // getAlbums(page = 1){
    //   axios.get(`http://localhost:8000/api/albums?page=${page}`)
    //   .then(res => {
    //     this.albums = res.data.albums
    //   })
    //   .catch(e => console.log(e))
    // },
    mouseEnter(e){
      e.target.children[0].classList.add('hovered')
    },
    mouseLeave(e){
      e.target.children[0].classList.remove('hovered')
    },
    // getSearch(e, page = 1){
    //   this.searchQuery = e.target.value
    //   if(e.target.value === ''){
    //     this.getAlbums()
    //   }else{
    //     axios.get(`http://localhost:8000/api/albums/search/${e.target.value}?page=${page}`)
    //     .then(res => {
    //       this.albums = res.data
    //       // console.log(res.data)
    //     })
    //     .catch(e => console.log(e))
    //   }
    // },
    getDate(e){
      this.dateQuery = e.target.value
      this.getAlbums()
    },
    getSearch(e){
      this.searchQuery = e.target.value
      this.getAlbums()
    },
    getAlbums(page=1){
      console.log(this.dateQuery)
      axios.get(`http://localhost:8000/api/albums?page=${page}`, {
        params: {
          query: this.searchQuery,
          date: this.dateQuery
        }
      })
      .then(res => {
        this.albums = res.data.albums
        this.dates = res.data.dates
        console.log(res.data)
      })
      .catch(e => console.log(e))
    },
  },
    
}
</script>

<style scoped>
p {
  margin-top: -45px;
  opacity: 0;
}
.hovered {
  background: black;
}
.hovered img {
  opacity: 0.5;
}
.hovered p {
  font-size: 25px;
  font-weight: 700;
  color: white;
  opacity: 1;
}
</style>