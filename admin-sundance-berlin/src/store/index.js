import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);
let cart =  window.sessionStorage.getItem('cart')

export default new Vuex.Store({
  state: {
    cart: cart ? JSON.parse(cart) : []
  },
  getters: {
    totalPrice: state => {
      let total = 0;
      state.cart.filter((item) => {
          total += (item.price * item.quantity);
      });
      // Avoiding Problems with Substraction in JavaScript, .toFixed(2) to have only 2 decimals
      return total.toFixed(2);
    }
},
  mutations: {
    // CART SHOP
    addToCart(state, map){
      // product is a copy from each object in array cart, any word can be used. See js .find() that include variable found & if(found){}
      let found = state.cart.find(product => product.id == map.id );
      if(found){
        found.quantity++;
      }else{
        // add quantity to map
        map.quantity = 1
        state.cart.push(map);
      }       
      this.commit('saveCart')
    },
    saveCart(state){
      window.sessionStorage.setItem('cart', JSON.stringify(state.cart));
  },
    removeFromCart(state, item){
        let index = state.cart.indexOf(item);
        state.cart.splice(index,1);
        this.commit('saveData');
    },
      // delete cart after paypal payment
    delCart(state, cart) {
      state.cart = []
      window.sessionStorage.cart = JSON.stringify([]);
    }
  },
  actions: {},
  modules: {}
});
