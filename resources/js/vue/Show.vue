<template>
  <div class="container">
    <div class="d-flex justify-content-between mt-5">
        <h3>{{ album.title }} - {{ album.artist }}</h3>
        <h3>{{ new Date(album.date_release).getFullYear() }}</h3>
    </div>
    <hr>
    <div class="row">
      <div class="col-6 text-center">
        <img :src="album.cover" alt="" class="col-10">
      </div>
      <div class="col-6">
        <div class="text-end">
          <button class="btn btn-primary me-2" @click="editBtn">Edit</button>
          <button class="btn btn-danger" @click="deleteBtn">Delete</button>
        </div>
        <h5>Tracks:</h5>
        <ul>
          {{ album.tracks }}
        </ul>
        
    <div class="text-end">
      <router-link class="btn btn-secondary" :to="{name: 'Home'}">Back</router-link>
    </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: ['id'],
  data(){
    return{
      album: []
    }
  },
  mounted(){
    this.getAlbum()
  },
  methods: {
    getAlbum(){
      axios.get(`http://localhost:8000/api/albums/${this.id}`)
      .then(res => {
        this.album = res.data.album
        console.log(res.data.album)
      })
      .catch(e => console.log(e))
    },
    editBtn(){
      this.$router.push({name: 'Edit', params: {id: this.id}})
    },
    deleteBtn(){
      // console.log(this.id)
      if(confirm('Are you sure you want to delete this data?')){
        axios.delete(`http://localhost:8000/api/albums/${this.id}`)
        .then(res => {
          alert(res.data)
          this.$router.push({name: 'Home'})
        })
        .catch(error => {
          console.log(error)
        })
      }
    }
  }
}
</script>

<style>

</style>