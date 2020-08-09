<template>
    <div class="container">

        <div class="col-md-6 offset-md-3 mt-5">
            <!-- card -->
            <div class="card">
                <!-- card-header -->
                <div class="card-header">
                    <p class="card-title text-center">User List</p>
                </div>
                <!-- /.card-header -->
                <!-- card-body -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>
                                    <div @click="deleteUser(user.id)"><img src="/img/icons/delete.png" class="conf-icons" /></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <!-- card-footer -->
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-center">
                        
                    </div>

                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
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
            users: {},
            currentUserId: ''
        }
    },
    methods: {
        loadUsers() {
            axios.get('/api/users').then(({
                data
            }) => (this.users = data))
        },
        deleteUser(id) {
            if(confirm("delete user")){
                if(this.currentUserId != id) {
                //delete user
                axios.delete('/api/users/destroy/' + id).then(() => {
                    // epmty users data
                    this.users = ''
                    // reload component
                    this.loadUsers();
                })
            } else {
                alert('You can not delete your self')
            }
            }           
        }       
    },
    created() {       
        this.loadUsers()
        axios.get('/api/user').then(response => {
        this.currentUserId = response.data.id
      })      
    }
}
</script>

<style lang="scss" scoped>
 .conf-icons {
   cursor: pointer;
 }
</style>