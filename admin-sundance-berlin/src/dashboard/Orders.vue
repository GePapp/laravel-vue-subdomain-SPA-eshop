<template>
<div class="container">
    <!---      ___________  NORMAL MODE ____________________          -->
    <div class="col-md-12 mt-5">
        <!-- card -->
        <div v-show="!printmode" class="card">
            <!-- card-header -->
            <div class="card-header">
                <p class="card-title text-center">Orders</p>
                <hr>
                <!-- search imput -->
                <div class="row">
                    <div class="text-right offset-md-6 col-md-6 searchDiv">
                        <input v-model="search" name="search" id="search" class="form-control form-control-sm">
                        <button class="btn-outline-dark btn-sm btnCardHeader" @click="getSearchOrders()">find</button>
                        <button class="btn-outline-dark btn-sm btnCardHeader" @click="showUnChecked()">showUnChecked</button>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- card-body -->
            <div class="card-body table-responsive p-0">

                <table class="table table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Cart</th>
                            <th>Checked</th>
                            <th>Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id" style="white-space: nowrap;">
                            <td class="text-left">
                                <strong>{{ order.name }}</strong><br />                               
                                {{ order.street }}<br />
                                {{ order.postcode }} - {{ order.city }}<br />
                                {{ order.email }}
                                <p v-if="order.phone">phone: {{ order.phone }}</p>
                            </td>
                            <td class="text-left">                                
                                <ul class="list-group">
                                    <li v-for="item in order.cart" :key="item.id" class="list-group-item">
                                        {{ item.title }} quantity: {{ item.quantity }}
                                    </li>
                                </ul>
                                Total amount: {{ order.totalPrice }} €<br />
                                Date: {{ order.created_at | moment("dddd, DD MMMM, YYYY") }}
                            </td>
                            <td>
                                <button v-show="order.unchecked" type="button" class="btn-outline-dark btn-sm" @click="setChecked(order.id)">setChecked</button>&nbsp;&nbsp;&nbsp;
                                <img v-show="!order.unchecked" src="/img/icons/check.png" class="conf-icons" />&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                <button type="button" class="btn-outline-dark btn-sm" @click="printOrder(order.id)">printOrder</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!-- card-footer -->
            <div class="card-footer">
                <div class="align-items-center justify-content-center pag-footer">

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
            <!-- /.card-footer -->
        </div>
    </div>
    <!---      ___________END NORMAL MODE____________________          -->
    <!---      ___________PRINT MODE____________________          -->
    <div v-show="printmode" class="row">
        <div v-for="order in orders" :key="order.id" class="col-12">
            <!-- Main content -->
            <div>
                <!-- info row -->
                <div class="row">
                    <div class="col-sm-4 invoice-col text-left">
                        From
                        <address>
                            <strong>Sundance Berlin</strong><br>
                            <strong>Astrologische Beratungspraxis und Schule</strong><br>
                            Georg Stockhorst<br>
                            Phone: 0049 (0)30 3451233<br>
                            mobil: 0049 (0)177 3451233<br>
                            Email: georgstc@web.de<br>                              
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 text-left">                       
                        To
                        <address>
                            <strong>{{ order.name }}</strong><br>
                            {{ order.email }}<br />
                            {{ order.postcode }} {{ order.street }} <br />
                            {{ order.country }}
                            <p v-if="order.phone">phone: {{ order.phone }}</p>
                            Order Date: {{ order.created_at | moment("dddd, DD MMMM, YYYY") }}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 text-left">                       
                        Date: {{ new Date() | moment("dddd, DD MMMM, YYYY") }}
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- Table row -->
                <div class="row">
                    <div class="col-8 table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in order.cart" :key="item.id">                                    
                                    <td class="text-left">{{ item.title }}</td>
                                    <td>{{ item.quantity }}</td>
                                    <td>{{ item.price }} €</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">

                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <p class="text-center">Amount</p>

                        <div class="table-responsive table-sm table-bordered">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>{{ order.totalPrice }} €</td>
                                    </tr>
                                    <tr>
                                        <th>Tax (...%)</th>
                                        <td>... €</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping:</th>
                                        <td>... €</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>... €</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row d-print-none">
                    <div class="col-12 p-4 text-right">
                        <button type="button" @click.prevent="printme" target="_blank" class="btn btn-sm btn-dark print-btn"> Print</button>
                        <button type="button" @click.prevent="reloadAfterPrint" class="btn btn-outline-dark btn-sm print-btn">Back to Orders</button>
                    </div>
                </div>

            </div>
            <!---      ___________END PRINT MODE____________________          -->
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
            orders: {},
            search: '',
            /*Variables-Mode to use for Pagination*/
            startmode: true,
            uncheckhmode: false,
            searchmode: false,
            printmode: false,
            pagination: 
            {
                current_page: 1,
                last_page: '', 
                total: ''
            },
            // *A
            offset: 2,
        }
    },
    methods: {
        loadOrders() {
            this.startmode = true
            this.search = ''
            if(this.searchmode || this.uncheckhmode) {
                this.pagination.current_page = 1
            }
            axios.get('api/getOrders?page=' + this.pagination.current_page)
                .then(({data}) => (this.orders = data.data, this.pagination.current_page = data.current_page, this.pagination.last_page = data.last_page, this.pagination.total = data.total))
        },
        reloadAfterPrint() {
            this.printmode = false
            if(this.searchmode){
                this.getSearchOrders()
            }
            else if(this.startmode) {
                this.loadOrders();
            }
            else {
                this.showUnChecked()
            }            
        },
        getSearchOrders() {
            if(this.startmode || this.uncheckhmode) {
                this.pagination.current_page = 1
            }
            axios.get('api/findOrders?page=' + this.pagination.current_page + '&search=' + this.search)
                .then(({data}) => (this.orders = data.data, this.pagination.current_page = data.current_page, this.pagination.last_page = data.last_page, this.pagination.total = data.total))
            this.searchmode = true;
            this.startmode = false;
            this.uncheckhmode = false;
        },

        setChecked(id) {
            axios.put('api/setChecked/' + id)
                .then(() => {})
                .catch(() => {})
        },

        showUnChecked() {
            this.search = ''
            if(this.startmode || this.searchmode) {
                this.pagination.current_page = 1
            }
            axios.get('api/findUnChecked?page=' + this.pagination.current_page)
                .then(({data}) => (this.orders = data.data, this.pagination.current_page = data.current_page, this.pagination.last_page = data.last_page, this.pagination.total = data.total))
            this.uncheckhmode = true;
            this.searchmode = false;
            this.startmode = false;
        },

        printOrder(id) {
            this.orders = {}
            axios.get('api/printOrder/' + id)
                .then(({data}) => (this.orders = data))

            this.printmode = true
        },
        printme() {
            window.print();
        },
        // Pagination
        // *A
        changePage(page) {
            if (page > this.pagination.last_page) {
                page = this.pagination.last_page;
            }
            this.pagination.current_page = page;
            if(this.startmode) {
                this.loadOrders()
            }
            else if(this.searchmode) {
                this.getSearchOrders()
            }
            else {
                this.showUnChecked()
            }            
        },
            // *A
        isCurrentPage(page){
            return this.pagination.current_page === page
        }
    },
    computed: {
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
    created() {
        // load orders
        this.loadOrders();
    }
}
</script>
<style lang="scss" scoped>
    .searchDiv{
        display: inline-flex;
    }
    .btnCardHeader{
        
        margin-right: 4px;
    }
    .warn {
        color: firebrick;
        font-size: 12px;
    }
     .pag-footer{
         padding-top: 20px;
         li {
             cursor: pointer;
         }
     }
     .print-btn {
         margin-right: 6px;
     }          
</style>
