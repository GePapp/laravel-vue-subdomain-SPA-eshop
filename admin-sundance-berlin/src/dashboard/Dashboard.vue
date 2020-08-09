<template>

<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2 text-center div-dash">
      <img src="/img/logos/dashboard.png" class="img-fluid">
      <div class="div-user">User: {{ name }}</div>
      <div><img src="/img/logos/GePapp-Logo.png"></div>
    </div>
  </div>
</div>

</template>

<script>
  import axios from 'axios'
  axios.defaults.withCredentials = true;
  axios.defaults.baseURL = 'http://localhost:8000'
  export default {
    data(){
      return {
        name: '',
      }
    },
    created() {
      axios.get('/api/user').then(response => {
        console.log(response)
        this.name = response.data.name
      })
    }      
  }
</script>

<style lang="scss" scoped>
 .div-dash {
   margin-top: 160px;
 }
 .div-user {
   padding: 20px;
 }
</style>
