<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Register</div>
                    <form @submit.prevent="register">
                        <div class="card-body">                                                      
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name">
                                    <div v-show="this.errors.name" class="warn text-left">{{ this.errors.name }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" v-model="email">
                                    <div v-show="this.errors.email" class="warn text-left">{{ this.errors.email }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password">
                                    <div v-show="this.errors.password" class="warn text-left">{{ this.errors.password }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                
                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" v-model="password_confirmation">
                                    <div v-show="this.errors.password_confirmation" class="warn text-left">{{ this.errors.password_confirmation }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">                            
                            <button type="submit" class="btn btn-primary">Register</button>                       
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
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: {}         
        }       
    },
    methods: {
        register() {
            // Empty errors
            // Empty errors
            this.errors = {};
            if(!this.name) {
                this.errors.name = 'Name is required';
            }
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
            if(this.password_confirmation !== this.password) {
                this.errors.password_confirmation = 'Password Confirmation do not match';
            }

            if(jQuery.isEmptyObject(this.errors)) {
                
                    axios.post('/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password
                        })
                    .then(response => {this.$router.push({ name: 'Users' })
                    })
               
            }
            
        }
    }  
}
</script>

<style>

</style>