import Vue from "vue";
import VueRouter from "vue-router";
// import Home from "../views/Home.vue";

// Admin
import Login from "../auth/Login.vue";
import Register from "../auth/Register.vue";
import Dashboard from "../dashboard/Dashboard.vue";
import Users from "../dashboard/Users.vue";
import Maps from "../dashboard/Maps.vue";
import Orders from "../dashboard/Orders.vue";
// Public
import Home from "../pages/Home.vue";
import Shop from "../pages/Shop.vue";
import Checkout from "../pages/Checkout.vue";


Vue.use(VueRouter);

const routes = [
  // Redirect a no existing route
  
  {
    path: "/",
    name: "publicHome",
    component: Home
    
  },

  // ------------  ADMIN AREA  -------------------

  //   L O G I N
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: { requiresVisitor: true }
  },
  //   R E G I S T E R
  {
    path: "/register",
    name: "Register",
    component: Register,
    meta: { requiresAuth: true }
  },
  //   D A S H B O A R D
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  //   U S E R S
  {
    path: "/users",
    name: "Users",
    component: Users,
    meta: { requiresAuth: true }
  },
  //  M A P S
  {
    path: "/maps",
    name: "Maps",
    component: Maps,
    meta: { requiresAuth: true }
  },
  //  O R D E R S
  {
    path: "/orders",
    name: "Orders",
    component: Orders,
    meta: { requiresAuth: true }
  },

  // ------------  PUBLIC AREA  --------------
   
  {
    path: "/shop",
    name: "publicShop",
    component: Shop,
  },
  {
    path: "/checkout",
    name: "publicCheckout",
    component: Checkout,
  },

  {
    path: "/about",
    name: "About",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/About.vue")
  },
  // Route don't match, pathMatch is automatically added to $route.params, redirect to login
  {
    path: '*',
    component: Home
}
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
