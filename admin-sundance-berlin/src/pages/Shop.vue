<template>   
    <!-- S H O P ----->
    <div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center">Sundance Shop</h5>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-deck" v-for="chunk in chunkedMaps" :key="chunk.id">                
                    <div class="card bg-transparent" v-for="item in chunk" :key="item.id">                    
                        <div class="card-body bg-transparent text-center">
                            <img :src="'/img/maps/'+item.imageName" class="card-img-shop">
                            <p class="text-center"><strong>{{ item.title }}</strong></p>
                            <p v-html="item.description" class="text-left">{{ item.description }}</p>
                            <p class="text-left">Preis: {{ item.price }} € </p>
                            <hr>
                            <div class="text-right">
                            <button class="btn btn-outline-dark btn-sm m-1" @click="addToCart(item.id)">Add to Cart</button>
                            <button class="btn btn-outline-dark btn-sm m-1" @click="checkout">Checkout</button>
                            </div>
                        </div> 
                    </div>                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 div-links">
                <!--Pagination-->
                    <ul class="pagination justify-content-center">
                        <li class="page-item" :class="{ disabled: pagination.current_page <= 1 }">
                            <a class="page-link" @click.prevent="changePage(1)">First page</a>
                        </li>

                        <li class="page-item" :class="{ disabled: pagination.current_page <= 1 }">
                            <a class="page-link" @click.prevent="changePage(pagination.current_page - 1)">Previous</a>
                        </li>
            
                        <!-- *A -->
                        <li class="page-item" v-show="$parent.smalDev" v-for="page in pages"  :key="page" :class="isCurrentPage(page) ? 'active' : ''">
                            <a class="page-link" @click.prevent="changePage(page)">{{ page }}
                                <span v-if="isCurrentPage(page)" class="sr-only">(current)</span>
                            </a>
                        </li>
                        <!-- *A End --> 

                        <li class="page-item" :class="{ disabled: pagination.current_page >= pagination.last_page }">
                            <a class="page-link" @click.prevent="changePage(pagination.current_page + 1)">Next</a>
                        </li>
                        
                        <li class="page-item" :class="{ disabled: pagination.current_page >= pagination.last_page }">
                            <a class="page-link" @click.prevent="changePage(pagination.last_page)">Last page</a>
                        </li>

                    </ul>
                    <!--Pagination End-->
            </div>
        </div>
        <!-- Modal -->
    <div class="modal fade" id="addCartModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-custom">
            <div class="modal-content">
                <div class="modal-body">
                    <div v-for="item in this.$store.state.cart" :key="item.id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-inline text-left">
                                    <img :src="'/img/maps/'+item.imageName" class="img-mini">                                   
                                </div>
                                <div class="d-inline text-left">
                                    <strong>{{ item.title }}</strong>                        
                                    <img src="/img/icons/delete.png" class="conf-icons" @click="$store.commit('removeFromCart',item)" />                           
                                </div>
                                <div>
                                    <p>Preis: {{ item.price }}</p>
                                    <p>Quantity: {{ item.quantity }}</p>
                                    <hr>
                                </div>
                            </div>
                        </div>                       
                    </div>
                </div>           
            </div>
        </div>
    </div>
    </div> 
</template>

<script>
// import unterscore (_) from lodash otherwise _.chunk() don't works 
import _ from 'lodash';
// axios import
import axios from 'axios'
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000'
export default {
    // ------------  DATA -------------------------
    data() {
        return {
            map: {},
            maps: {},
            pagination: 
            {
                current_page: 1,
                last_page: '', 
                total: ''
            },
            // *A Pagination
            offset: 2
        }   
    },
    // ------------  METHODS -------------------------
    methods: {
         // SHOW maps axios request and put data into maps data object
        loadMaps() {
            axios.get('/api/publicMap?page=' + this.pagination.current_page).then(({
                data
            }) => (this.maps = data.data, this.pagination.current_page = data.current_page, this.pagination.last_page = data.last_page, this.pagination.total = data.total))
        },
        // Cart
        loadMap() {

        },
        addToCart(id) {
            this.map = {}
            axios.get('/api/publicMap/show/' + id)
            .then(({data}) => (this.map = data))
            .then(() => {this.$store.commit('addToCart', this.map)})
            //reload maps in shop
            .then(()=> {this.loadMaps()})
            // show Modal
            .then(() => {// show Modal
            $('#addCartModal').modal('show')})
            // close Modal
            .then(() => {
                setTimeout( 
                () => {
                    $('#addCartModal').modal('hide')                                          
                    }, 3000)
            })                    
        },
        checkout(){
            $('#addCartModal').modal('hide')
            // Dont use path: router.push('home') or router.push({ path: 'home' })
            this.$router.push({ name: 'publicCheckout' })           
        },
        // *A Pagination       
        changePage(page) {
            if (page > this.pagination.last_page) {
                page = this.pagination.last_page;
            }
            this.pagination.current_page = page;
            this.loadMaps()            
            },
            // *A Pagination
            isCurrentPage(page){
                return this.pagination.current_page === page
            }
    },
    // ------------  COMPUTED -------------------------
    computed: {
        chunkedMaps () {
            return _.chunk(this.maps,2)
        },
        // *A
        pages() {
            let pages = []
            let from = 1
            if (from < 1) {
                from = 1
            }
            let to = Math.ceil(this.pagination.total / this.offset)
            while (from <= to) {
                pages.push(from)
                from++
            }
            return pages
        }
    },
   
    // ------------  CREATED -------------------------
    created() {
        this.loadMaps()
    }
}
</script>

<style lang="scss" scoped>
    .card {
        border: 0px;      
    }
    .div-links {
        margin-top: 20px;
    }
    .page-link {
        cursor: pointer;
    }
    .card-img-shop {
        width: 30%;
        height: auto;
        margin-bottom: 20px;
    }
    .img-mini {
        width: 10%;
        height: auto;
        float: left;
        margin-bottom: 6px;
        }
    .conf-icons {
        padding-left: 20px;
        cursor: pointer;
    }
</style>