<template>
  <form class="container" v-on:submit.prevent="updateAlbum" enctype="multipart/form-data">
    <h3 class="mt-5 mb-3">Update Album</h3>
    <hr>
    <div class="row">
      <div class="col">
        <!-- <img class="mb-3" :src="image" alt="Album Cover" width="200" height="200" /> -->
        <div class="mb-3">
          <label class="form-label">Album Cover</label>
          <input type="file" class="form-control" v-on:change="setFile">
        </div>
        <div class="mb-3">
          <label class="form-label">Album Title</label>
          <input type="text" class="form-control" v-model="album.title">
        </div>
        <div class="mb-3">
          <label class="form-label">Artist</label>
          <input type="text" class="form-control" v-model="album.artist">
        </div>
        <div class="mb-3">
          <label class="form-label">Date Release</label>
          <input type="date" class="form-control" v-model="album.date_release">
        </div>
      </div>
      <div class="col">
        <div class="mb-3">
          <label class="form-label">Tracks List</label>
          <textarea class="form-control" rows="10" v-model="album.tracks"></textarea>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary me-2">Submit</button>
    <button class="btn btn-secondary" @click="backBtn">Cancel</button>
  </form>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Edit',
  props: ['id'],
  data(){
    return{
      // image: '',
      album: {
        cover: '',
        title: '',
        artist: '',
        date_release: '',
        tracks: ''
      }
    }
  },
  mounted(){
    this.getAlbum()
  },
  methods:{
    getAlbum(){
      axios.get(`http://localhost:8000/api/albums/${this.id}`)
      .then(res => {
        this.album = res.data.album
      })
      .catch(e => console.log(e))
    },
    setFile(e){
      this.album.cover = e.target.files[0]
    },
    updateAlbum(){

      const formData = new FormData();
      formData.append('cover', this.album.cover);
      formData.append('title', this.album.title);
      formData.append('artist', this.album.artist);
      formData.append('date_release', this.album.date_release);
      formData.append('tracks', this.album.tracks);

      axios.post(`http://localhost:8000/api/albums/${this.id}`, formData)
      .then(res => {
        this.$router.push({name: 'Home'})
      })
      .catch(error => {
        if (error.response) {
          console.log(error.response.data.errors);
        } else {
          console.log(error);
        }
      })
    },
    backBtn(){
      this.$router.push({name: 'Home'})
      // this.$router.go(-1)
    }
  }
}
</script>

<style>

</style>