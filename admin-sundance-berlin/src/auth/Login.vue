<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Login</div>
                    <form @submit.prevent="login">
                        <div class="card-body">                            
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>                               
                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" v-model="email">
                                    <div v-show="this.errors.email" class="warn text-left">{{ this.errors.email }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control " v-model="password">
                                    <div v-show="this.errors.password" class="warn text-left">{{ this.errors.password }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">                            
                            <button type="submit" class="btn btn-primary btn-sm">Login</button>
                            <div v-show="errorMessage" class="warn text-center">{{ errorMessage }}</div>                     
                        </div>
                    </form>               
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000'

export default {
    data() {
        return {           
            email: '',
            password: '',
            errors: {},
            errorMessage: '',
        }       
    },
    methods: {
        login() {
            // Empty errors
            this.errors = {};
            if(!this.email) {
                this.errors.email = 'Email is required';
            }
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email) === false)
                {
                this.errors.email = 'Email is invalid';
                }
            if(!this.password) {
                this.errors.password = 'Password is required';
            }

            if(jQuery.isEmptyObject(this.errors)) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', {
                        email: this.email,
                        password: this.password
                    })
                    .then(response => { 
                        localStorage.setItem('isLoggedIn', 'true')
                        this.$router.push({ name: 'Dashboard'})
                    })
                    .catch(error => {
                    // console.log(error.response.data);
                    const key = Object.keys(error.response.data.errors)[0]
                    this.errorMessage = error.response.data.errors[key][0]
                    })     
                });
            }                                 
        } 
    }  
}
</script>

<style>
    .warn {
    color: firebrick;
    font-size: 12px;
}
</style>