<template>
  <div>
    <div class="main">
      <!-- Sign up form -->
      <section class="signup">
        <div class="container container-signin">
          <div class="row justify-content-center">
            <div class="col-lg-12 col-xs-12 col-sm-12">
              <center>
                <a href="/" aria-label="Easynet">
                  <img
                    :src="require('~/assets/logo/easynet_logo.svg')"
                    alt="Logo"
                    width="250"
                  />
                </a>
              </center>
            </div>
          </div>
          <div class="signup-content">
            <div class="signup-form">
              <h2 class="form-title">Login</h2>
              
              <div v-if="register.message" class="alert alert-success" v-html="register.message"></div>
              
              <div v-if="error_login">
                <div class="alert alert-danger" role="alert">
                  <p class="text-warning">User not found</p>
                  <p>{{ data_error_login }}</p>
                </div>
              </div>

              <div v-if="loginFailed">
                <div class="alert alert-warning" role="alert">
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                    @click="CloseAlert"
                  ></button>
                  <p class="text-danger">Login Failed</p>
                  <p>{{ failed }}</p>
                </div>
              </div>

              
              <form
                @submit.prevent="login"
                class="register-form"
                id="register-form"
              >
              <input type="hidden" name="ip" v-model="ip" />
              <input type="hidden" name="city" v-model="city" />
              <input type="hidden" name="province" v-model="region" />

                <div class="form-group">
                  <div v-if="error" class="mt-2 mb-3 col-lg-6 col-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Ooops!</strong> Periksa kembali kolom form login dengan lengkap / benar
                    </div>
                  </div>

                  <label for="email"><i class="zmdi zmdi-email"></i></label>
                  <input @mousedown="ResetForm"
                    type="text"
                    name="email"
                    id="email"
                    placeholder="Your Email"
                    v-model="user.email"
                    autofocus
                  />
                    <div v-if="validation.email" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
                      {{ validation.email[0] }}
                    </div>
                  <br />
                </div>

                <div class="form-group">
                  <label for="password"><i class="zmdi zmdi-lock"></i></label>
                  <input @mousedown="ResetForm"
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Password"
                    v-model="user.password"
                  />
                    <div v-if="validation.password" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
                      {{ validation.password[0] }}
                    </div>
                </div>
                <div id="show-password" class="show" v-on:click="showPassword">
                  <div v-if="showing === false">
                    <span v-html="show"></span> Show Password
                  </div>
                  <div v-else><span v-html="hide"></span> Hide Password</div>
                </div>
                <br />
                <div class="form-group">
                  <input
                    type="checkbox"
                    name="agree-term"
                    id="agree-term"
                    class="agree-term"
                  />
                  <label for="agree-term" class="label-agree-term"
                    ><span><span></span></span>Remember Me</label
                  >
                </div>
                <div class="form-group form-button">
                  <div class="d-grid gap-2">
                    <button class="btn btn-primary rounded-pill" type="submit">
                      <div v-if="loading">
                        <span
                          class="spinner-border spinner-border-sm"
                          role="status"
                          aria-hidden="true"
                        ></span>Loading...
                        <span class="visually-hidden">Loading...</span>
                      </div>
                      <div v-else>Login</div>
                    </button>
                  </div>
                </div>
              </form>

              <div class="social-login">
                <span class="social-label">Or login with</span>
                <ul class="socials">
                 <!--  <li>
                    <a href="#"
                      ><i class="display-flex-center zmdi zmdi-facebook"></i
                    ></a>
                  </li>
                  <li>
                    <a href="#"
                      ><i class="display-flex-center zmdi zmdi-twitter"></i
                    ></a>
                  </li> -->
                  <li>
                    <div class="d-grid gap-2">
                      <a href="#" class="btn rounded-pill"
                        ><i class="display-flex-center zmdi zmdi-google"></i
                      ></a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="signup-image">
              <figure>
                <SigninArt />
              </figure>
              <nuxt-link to="/auth/register" class="signup-image-link"
                >Belum punya akun ? (Daftar disini)</nuxt-link
              >
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import SigninArt from "@/components/Molecules/Auth/signin";

export default {
  components: {
    SigninArt,
  },
  
  data() {
    return {
      show: `<i class="zmdi zmdi-eye"></i>`,
      hide: `<i class="zmdi zmdi-eye-off"></i>`,
      showing: false,
      ip:'',
      city: '',
      region: '',
      user: {
        email: "",
        password: ""
      },
      error: null,
      validation: {},
      activated: null,
      activated_message: "",
      loginFailed: null,
      failed: {},
      error_login: null,
      data_error_login: {},
      loading: null,
      checked: {},
      register:{
        success: false,
        message: ''
      },
      haslogin:{
        status: null,
        message: ''
      }
    };
  },

  beforeMount(){
    this.checkAuth()
  },

  mounted(){
    this.$axios('https://api.ipify.org/?format=json')
    .then(res => {
      this.ip = res.data.ip
    })
    .catch(err => {
      console.log(err.message)
    }),
    this.Location(),
    this.CheckRegister(),
    this.checkToken(this.auth.token),
    this.dataUser()
  },

  methods: {
    Location(){
      this.$axios.get(`https://ipapi.co/${this.ip}/json`)
      .then(res => {
        this.city = res.data.city
        this.region = res.data.region
      })
      .catch(err => console.log(err.message))
    },
    checkToken(token){
      if(token){
        this.$swal({
          icon: 'info',
          title: 'Oops...',
          text: `Kamu sudah login sebagai  : ${this.auth.roles.toLowerCase()}`
        })
        this.$router.push({
          path: `/dashboard/${this.auth.roles.toLowerCase()}/${this.auth.username}`
        })
      }
    },
    checkAuth() {
      this.$store.commit("auths/CHECK_AUTH", "checked")
    },
    dataUser() {
      this.$store.dispatch("auths/storeUser", process.env.BASEURL)
    },
    CheckRegister(){
      const checked=localStorage.getItem('register_success')
      this.register.success=true
      this.register.message=checked
    },
    ResetForm(){
      this.error=false
      this.error_login=false
      this.activated=false
      this.validation=''
    },
    CloseAlert() {
      this.loginFailed = "";
      this.failed = false;
      this.data_error_login = "";
      this.error_login = false;
      this.activated = false;
      this.activated_message = "";
    },
    CheckLocation() {
      const config = {
        baseurl: process.env.BASEURL,
        token: process.env.APITOKEN,
      };
      this.$axios
        .get(`${config.baseurl}/locator/${config.token}`)
        .then((res) => {
          this.city = res.data.data.city;
          this.region = res.data.data.region;
        })
        .catch((err) => {
          console.log(err.message);
        });
    },
    login() {
      this.loading = true;
      const user = {
        email: this.user.email,
        password: this.user.password,
        ip: this.ip,
        city: this.city,
        province: this.region
      };
      this.$axios
        .post(`${process.env.BASEURL}/login`, {
          email: user.email,
          password: user.password,
          ip: user.ip,
          city: user.city,
          province: user.province
        })
        .then((res) => {
          this.error_login = "";
          this.data_error_login = "";
          this.loginFailed = "";
          this.error_login = "";
          this.failed = "";
          this.error=false

          if (res.data.error_login) {
            this.loading = false;
            this.error_login = true;
            this.data_error_login = res.data.err_message;
            this.$swal({
              icon: 'error',
              title: 'Oops...',
              text: this.data_error_login,
              footer: ''
            })
          } else {
            if (res.data.activated) {
              this.activated = true;
              this.activated_message = res.data.message;
              this.$swal({
                icon: 'error',
                title: 'Oops...',
                text: this.activated_message,
                footer: ''
              })
            }
            if (res.data.success) {
              this.loading = false;
              this.error_login = false;
              this.loginFailed = false;
              this.checked = {
                token: res.data.token,
                username: res.data.data.username,
                roles: res.data.data.roles.includes("ADMIN")
                  ? "ADMIN"
                  : res.data.data.roles.includes("CUSTOMER")
                  ? "CUSTOMER"
                  : res.data.data.roles.includes("SALES")
                  ? "SALES"
                  : "SUPPORT",
                id: res.data.data.id,
              };
              localStorage.setItem("checked", JSON.stringify(this.checked));

              if (this.checked.roles === "ADMIN") {
                this.$router.push({
                  // path: "/dashboard/admin",
                  path: `/dashboard/admin/${this.checked.username}`
                });
              } else if (this.checked.roles === "CUSTOMER") {
                this.$router.push({
                  path: `/profile/customer/${this.checked.username}`,
                  // name: 'member',
                  // params: {username: this.checked.username}
                });
              } else if(this.checked.roles === "SALES"){
                this.$router.push({
                  // path: "/dashboard/admin",
                  path: `/dashboard/sales/${this.checked.username}`
                });
              } else {
                this.$router.push({
                  // path: "/dashboard/Staff",
                  path: `/dashboard/support/${this.checked.username}s`
                });
              }
            } else {
              this.loading = false;
              this.loginFailed = true;
              this.error_login = false;
              this.failed = res.data.message;
            }
          }
        })
        .catch((err) => {
          this.$swal({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!'
          })
          console.log(err.message)
          this.loading = false;
          this.loginFailed = false;
          this.error_login = false;
          this.failed = "";
          this.error=true
          this.validation = err.response.data;
        });
    },
    showPassword() {
      const password = document.querySelector("#password");
      if (password.type === "password") {
        password.type = "text";
        this.showing = true;
      } else {
        password.type = "password";
        this.showing = false;
      }
    },
  },
  computed: {
    auth() {
      return this.$store.getters["auths/getAuth"];
    },
    userdata() {
      return this.$store.getters["auths/getUser"];
    },
    
  },
};
</script>

<style>
.container-signin {
  background: rgba(255, 255, 255, 0.9);
  opacity: 0.9;
}
</style>
