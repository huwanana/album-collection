<template>
  <form class="container" v-on:submit.prevent="saveAlbum" enctype="multipart/form-data">
    <h3 class="mt-5 mb-3">Add new Album</h3>
    <hr>
    <div class="row">
      <div class="col">
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
    <button class="btn btn-primary me-2" type="submit">Submit</button>
    <button class="btn btn-secondary" @click="backBtn">Cancel</button>
  </form>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Create',
  data(){
    return{
      album: {
        cover: '',
        title: '',
        artist: '',
        date_release: '',
        tracks: ''
      }
    }
  },
  methods:{
    setFile(e){
      this.album.cover = e.target.files[0]
    },
    saveAlbum(){

      let data = new FormData();
      data.append('cover', this.album.cover);
      data.append('title', this.album.title);
      data.append('artist', this.album.artist);
      data.append('date_release', this.album.date_release);
      data.append('tracks', this.album.tracks);

      axios.post('http://localhost:8000/api/albums', data)
        .then(res => {
          this.album = {
            cover: '',
            title: '',
            artist: '',
            date_release: '',
            tracks: ''
          }
          this.$router.push({name: 'Home'})
        })
        .catch(e => console.log(e))
      // console.log(data.has('cover'))
      // console.log(data.has('title'))
      // console.log(data.has('artist'))
      // console.log(data.has('date_release'))
      // console.log(data.has('tracks'))
    },
    backBtn(){
      this.$router.push({name: 'Home'})
    }
  }
}
</script>

<style>

</style>