<template>
  <div id="app">
    <div>
      <!-- L O G I N  -->
      <!-- If Route don't match (asterisk * route), pathMatch is automatically added to $route.params -->
      <div v-if="this.$route.path === '/login'">
        <!-- Content -->
        <div class="container-login">
          <router-view></router-view>
        </div>
      </div>

      <!-- P U B L I C  A R E A -->
      <div
        v-else-if="this.$route.params.pathMatch || this.$route.name.match('public*') || this.$route.path === '/'"
      >
        <nav class="navbar sticky-top navbar-expand-lg navbar-light">
          <!-- <a class="navbar-brand" href="#">Navbar</a> -->
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <router-link :to="{ name: 'publicHome' }" class="nav-link">Home</router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'publicShop' }" class="nav-link">Shop</router-link>
              </li>
              <!--li class="nav-item">
                      <router-link :to="{ name: 'checkout' }" class="nav-link">Checkout</router-link>
              </li>-->

              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>
        <!-- Content -->
        <div class="container content-public">
          <router-view></router-view>
        </div>
      </div>

      <!-- A D M I N  A R E A -->
      <div v-else>
        <nav id="sidenav" class="d-print-none" v-bind:style="{ left: Navleft + 'px'}">
          <!-- toggle button -->
          <div class="toggle-btn" v-on:click="toggleSidenav()">
            <span></span>
            <span></span>
            <span></span>
          </div>
          <!-- logo -->
          <div class="logo">
            <img src="/img/logos/GePapp-Logo.png" />
            <p class="text-right">Admin Panel</p>
          </div>

          <ul class="list-unstyled components text-left">
            <router-link :to="{ name: 'Dashboard' }" class="nav-link">Dashboard</router-link>
            <li>
              <a
                href="#pageSubmenu"
                data-toggle="collapse"
                aria-expanded="false"
                class="dropdown-toggle"
              >Users</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <router-link :to="{ name: 'Users' }" class="nav-link">Index</router-link>
                <router-link :to="{ name: 'Register' }" class="nav-link">Register</router-link>
              </ul>
            </li>
            <router-link :to="{ name: 'Maps' }" class="nav-link">Maps</router-link>
            <router-link :to="{ name: 'Orders' }" class="nav-link">Orders</router-link>
            <li>
              <a
                href="#pageSubmenu"
                data-toggle="collapse"
                aria-expanded="false"
                class="dropdown-toggle"
              >Pages</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                  <a href="#">Page 1</a>
                </li>
                <li>
                  <a href="#">Page 2</a>
                </li>
                <li>
                  <a href="#">Page 3</a>
                </li>
              </ul>
            </li>
            <li class="nav-item" @click="logout">Logout</li>
          </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
          <div
            class="container container-admin"
            v-bind:style="{ left: Contleft + 'px', width: Contwidth + 'px'}"
          >
            <router-view></router-view>
          </div>
        </div>
      </div>
    </div>

    <!-- footer -->
    <div class="footer">
      <div class="text-right logo-footer">
        powered by
        <img src="/img/logos/GePapp-Logo.png" />
      </div>
      <p class="text-right">@Copyright Georg Pappas</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000";
export default {
  name: "app",
  data() {
    return {
      // isActive: true,
      Navleft: 0,
      Contleft: 280,
      Contwidth: "",
      // for nav-links
      smalDev: true
    };
  },

  methods: {
    // Show and hidde sidenav, dynamicaly load left  css style and bind trough v-bind
    toggleSidenav() {
      // this.isActive = !this.isActive
      let Navleft = this.Navleft;

      if (Navleft == 0) {
        this.Navleft = -180;
        this.Contleft = 10;
      } else {
        this.Navleft = 0;
        this.Contleft = 280;
      }
    },
    // HANDLE @media queries: onResize() & window.addEventListener('resize', this.onResize) & beforeDestroy(){window.removeEventListener('resize', this.onResize)}
    onResize() {
      if (window.innerWidth < 768) {
        this.Navleft = -180;
        this.Contleft = 10;
        this.Contwidth = window.innerWidth;
      } else {
        this.Navleft = 0;
        this.Contleft = 280;
        this.Contwidth = window.innerWidth - 280;
      }
      // for nav-links
      if (window.innerWidth > 480) {
        this.smalDev = true;
      } else {
        this.smalDev = false;
      }
    },
    logout() {
      axios.post("/logout").then(response => {
        localStorage.removeItem("isLoggedIn");
        this.$router.push({ name: "Login" });
      });
    }
  },
  created() {
    window.addEventListener("resize", this.onResize);
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.onResize);
  }
};
</script>

<style lang="scss">
#app {
  position: relative;
  font-family: Avenir, Helvetica, Arial, sans-serif;
  font-size: 14px;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
// set overflow-x only for home page to solve aos overflow-x issue
body.home {
  overflow-x: hidden;
}
body {
  margin-bottom: 160px !important; /* Margin bottom by footer height IMPORTANT */
  background-color: rgb(240, 240, 240) !important;
}

/* Public Container */
.content-public {
  margin-top: 40px;
  margin-bottom: 10px;
  z-index: 998;
}
/* Admin Container */
.container-admin {
  top: 0px;
  left: 280px;
  padding-top: 40px;
  transition: all 500ms linear;
}
/* Login Container */
.container-login {
  margin-top: 80px;
}
/* Admin area, Fixed sidenav, full height */
#sidenav {
  height: 100%;
  width: 180px;
  top: 0px;
  position: fixed;
  z-index: 999;
  background-color: rgb(41, 40, 40);
  color: rgb(255, 255, 255);
  padding-top: 40px;
  transition: all 500ms linear;
  .logo {
    padding-bottom: 10px;
  }
  p {
    color: rgb(2, 168, 160);
    padding-top: 4px;
    padding-right: 16px;
    font-size: 12px;
  }
  hr {
    color: rgb(255, 255, 255);
  }
  a {
    color: rgb(255, 255, 255);
  }
  a:hover {
    color: rgb(192, 183, 183);
    text-decoration: none;
  }
  li {
    padding-top: 20px;
    padding-left: 20px;
    cursor: pointer;
  }
  // style vor router-link: use nav-link
  .nav-link {
    padding-top: 20px !important;
    padding-left: 20px !important;
    padding-right: 0px;
    padding-bottom: 0px;
  }
  li:hover {
    color: rgb(192, 183, 183);
  }
  .toggle-btn {
    position: absolute;
    left: 200px;
    top: 0px;
    background-color: ghostwhite;
    color: #000;
    cursor: pointer;
    span {
      display: block;
      width: 30px;
      height: 3px;
      margin: 5px 0px;
      background: rgb(48, 48, 48);
    }
  }
}
.footer {
  position: fixed;
  margin-top: 10px !important;
  background-color: rgb(41, 40, 40);
  bottom: 0px;
  padding-top: 10px;
  width: 100%;
  height: 60px;
  color: rgb(126, 123, 123);
  font-size: 12px;
  z-index: 999;
  p {
    padding-right: 20px;
  }
  .logo-footer {
    padding-right: 20px;
  }
}
.navbar {
  font-size: 14px;
  font-weight: bold;
  letter-spacing: 1px;
  background-color: rgb(240, 240, 240) !important;
}

.navbar-nav > li > a {
  padding-top: 40px;
  padding-bottom: 0px;
  margin-right: 30px;
}
.dropdown-item {
  font-size: 12px;
}
.head-banner {
  background-image: url("/img/pages/home.png");
  background-size: 100% 100%;
  height: 320px;
  font-family: Monaco;
  .p-header-title {
    padding-top: 180px;
    padding-bottom: 0px;
    font-size: 30px;
  }
  .p-header {
    padding-bottom: 0px;
    font-size: 16px;
    margin-left: 10%;
  }
}
</style>
