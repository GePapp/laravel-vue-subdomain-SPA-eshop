<template>
    <div>
      <!-- --------- chekout --------------- -->      
      <div class="row" v-show="!paypalSection">
        <!-- left side -->
        <div class="col-md-6 mt-6">
            <div class="row">
              <div>
                  <h5 class="text-center h-title">Shopping Basket</h5>
                  <hr>
                  <ul>
                    <li v-for="item in this.$store.state.cart" :key="item.id">                           
                        <img :src="'/img/maps/'+item.imageName" class="img-mini">
                        <p><strong>{{ item.title }}</strong>
                          <span class="float-right remove-item" @click="$store.commit('removeFromCart',item)">
                            <i class="fas fa-trash text-red"></i>
                          </span>
                          </p>
                        <p>Preis: {{ item.price }} €</p>
                        <p>Quantity: {{ item.quantity }}</p>
                        <hr>
                    </li>
                  </ul>
              </div>
            </div>
          <div class="row">
              <div><p class="text-right price-cl">Total Price : {{ this.$store.getters.totalPrice  }} €</p></div>
          </div>
        </div>                
          <!-- right side -->
        <div class="col-md-6">          
          <!--  FORM-->
          <div class="card">
              <div class="card-header text-center">Shipping Data</div>
              
                <!--FORM DATA-->
                <form id="payment-form" @submit.prevent>
                  <div class="card-body">
                  <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                    <div class="col-md-6">
                      <input v-model="customer.name" id="name" type="text" class="form-control" name="name">
                     <div v-show="this.errors.name" class="warn text-left">{{ this.errors.name }}</div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="street" class="col-md-4 col-form-label text-md-right">Straße</label>
                    <div class="col-md-6">
                      <input v-model="customer.street" id="street" type="text" class="form-control" name="street">
                      <div v-show="this.errors.street" class="warn text-left">{{ this.errors.street }}</div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="postcode" class="col-md-4 col-form-label text-md-right">PLZ</label>
                    <div class="col-md-6">
                      <input v-model="customer.postcode" id="postcode" type="text" class="form-control" name="postcode">
                      <div v-show="this.errors.postcode" class="warn text-left">{{ this.errors.postcode }}</div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="city" class="col-md-4 col-form-label text-md-right">Stadt</label>
                    <div class="col-md-6">
                      <input v-model="customer.city" id="city" type="text" class="form-control" name="city">
                      <div v-show="this.errors.city" class="warn text-left">{{ this.errors.city }}</div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="country" class="col-md-4 col-form-label text-md-right">Land</label>
                    <div class="col-md-6">
                      <input v-model="customer.country" id="country" type="text" class="form-control" name="country">
                      <div v-show="this.errors.country" class="warn text-left">{{ this.errors.country }}</div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                    <div class="col-md-6">
                      <input v-model="customer.email" id="email" type="text" class="form-control" name="email">
                      <div v-show="this.errors.email" class="warn text-left">{{ this.errors.email }}</div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="phone" class="col-md-4 col-form-label text-md-right">Telefon</label>
                    <div class="col-md-6">
                      <input v-model="customer.phone" id="phone" type="text" class="form-control" name="phone">                      
                    </div>
                  </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                        <button type="submit" class="btn btn-success" @click="setSection">Continue</button>                            
                    </div>
                  </div>                  
                </form>             
            </div>
        </div>
      </div>
        <!-- ------- ORDER -----------    -->
        <div class="row" v-show="paypalSection">
          <div class="col-md-6 offset-md-3">
            <p class="text-center"><strong>Your Order</strong></p>
            <hr>            
              <div v-for="item in this.$store.state.cart" :key="item.id">                                                   
                  <p><i>{{ item.title }}</i> - Quantity: {{ item.quantity }}</p>
              </div>
            <hr>            
            <p><strong>Shipping Data</strong></p>
            <p>Street: {{ this.customer.street }}</p>
            <p>City: {{ this.customer.postcode }} {{ this.customer.city }}</p>
            <p>Country: {{ this.customer.country }}</p>
            <hr>
            <p><strong>Contact</strong></p>
            <p>email: {{ this.customer.email }}</p>
            <p>Phone: {{ this.customer.phone }}</p>
            <hr>
            <p>Total Price: {{ this.$store.getters.totalPrice  }} €</p>
            <hr>
            <div ref="paypal" class="col-md-6 offset-md-3 text-center"></div>
          </div>
        </div>
        <!-- ------- END ORDER -----------    -->
    </div>
</template>
<script>
// axios import
import axios from 'axios'
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000'
export default {
  data() {
        return {
          customer: {
              name: '',
              email: '',
              postcode: '',
              city: '',
              street: '',
              country: '',
              phone: ''
          },
          paypalSection: false,
          errors: {}
        }
  },
  mounted: function() {
    const script = document.createElement("script");
    script.src =
      "https://www.paypal.com/sdk/js?client-id=xxxxxxxxxxxxxxxxxxxx&disable-funding=credit,card";
    script.addEventListener("load", this.setLoaded);
    document.body.appendChild(script);
  },
  methods: {
    setLoaded: function() {
      this.loaded = true;
      window.paypal
        .Buttons({
          style: {
                color:  'white',
                label:  'pay',
                size: 'medium'
            },
          createOrder: (data, actions) => {
            return actions.order.create({
              purchase_units: [
                {
                  amount: {
                    currency_code: "USD",
                    value: this.$store.getters.totalPrice
                  }
                }
              ]
            });
          },
          onApprove: async (data, actions) => {
            const order = await actions.order.capture();
            this.data;
            this.paidFor = true;
                      
            // store order in database after payment
            axios.post('/api/publicStoreOrder', this.customer)
            .then(() => {
              // delete local order
              this.order = {}
              // delete local storage cart data
              this.$store.commit('delCart')
                })
            .then(() => {
              alert('Transaction Successful. We send you an email.')
            })
            .then(() => {
              this.customer = {}                         
            })
            .then(() => {
              // redirect
              this.$router.push('/shop')                        
            })
            .catch(() => {})
            // console.log(order);
          },
          onError: err => {
            console.log(err);
          }
        })
        .render(this.$refs.paypal);
    },
    // Push titel->quantity data into form as order object - check form
    pushOrder() { 
      let customer = this.customer
      let cart = this.$store.state.cart
      cart.forEach((item) => { delete item.description });
      cart.forEach((item) => { delete item.updated_at });
     
      customer.cart = cart
      customer.totalPrice = this.$store.getters.totalPrice
    },
    setSection() {
      this.errors = {};
      if(!this.customer.name) {
          this.errors.name = 'Name is required';
      }
      else if(!this.customer.street) {
          this.errors.street = 'Street is required';
      }
      else if(!this.customer.postcode) {
          this.errors.postcode = 'Postcode is required';
      }
      else if(!this.customer.city) {
          this.errors.city = 'City is required';
      }
      else if(!this.customer.country) {
          this.errors.country = 'Country is required';
      }     
      else if(!this.customer.email) {
          this.errors.email = 'Email is required';
      }
      else if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.customer.email) === false){
          this.errors.email = 'Email is invalid';
      }
      // execute, show paypal button 
      else {
        this.paypalSection = true
      }     
    }, 
    afterTransaction() {
      this.customer = {}
    }
  },
  created() {
    this.pushOrder()
    }
}
</script>

<style lang="scss" scoped>
    img {
      width: 30%;
      height: auto;
      margin-bottom: 20px;
      margin-right: 40px;
      float: left;
      clear: left;
      }
      li {
          list-style: none;
          float: left;
          clear: left;
          width: 70%;
      }
      p {
          margin-left: 10px;
          
      }
      .remove-item { 
          cursor: pointer; 
      }
      .price-cl {
        padding-left: 20px;
      }
      .h-title {
        margin-bottom: 10px;
      }
      hr {
        margin-bottom: 20px;
      }
      .warn {
      color: firebrick;
      font-size: 12px;
      }
</style>