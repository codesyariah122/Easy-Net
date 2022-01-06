<template>
  <div>
    <div class="main">
      <!-- Sing in  Form -->
      <section class="sign-in">
        <div class="container container-signup">
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
          <div class="signin-content">
            <div class="signin-image">
              <figure>
                <SignupArt />
              </figure>
              <nuxt-link to="/auth/login" class="signup-image-link"
                >Sudah punya akun ? (Login disini)</nuxt-link
              >

            </div>

            <div class="signin-form">
              <h2 class="form-title">Sign up</h2>

              <div v-if="error" class="mt-2 mb-3 col-lg-12 col-xs-12 col-sm-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Ooops!</strong> Periksa kembali kolom form register dengan lengkap / benar
                </div>
              </div>
              
              <form
                @submit.prevent="Register"
                class="register-form"
                id="register-form"
              >
                <!-- hidden setup -->
                <input type="hidden" name="city" v-model="hidden.city" />
                <input type="hidden" name="province" v-model="hidden.region" />
                <input
                  type="hidden"
                  name="login"
                  value="0"
                  v-model="hidden.login"
                />
                <input
                  type="hidden"
                  name="roles[]"
                  v-model="hidden.roles"
                  id="roles"
                />
                <input
                  type="hidden"
                  name="status"
                  v-model="hidden.status"
                  id="roles"
                />
                <!-- end hidden -->

                <div class="form-group">
                  <label for="name"
                    ><i class="zmdi zmdi-account material-icons-name"></i
                  ></label>
                  <input @mousedown="ResetForm"
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Your Name"
                    v-model="field.name"
                  />
                  <div v-if="validation.name" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
                    {{ validation.name[0] }}
                  </div>
                </div>
                <br />
                <vue-tel-input @mousedown="ResetForm"
                  type="text"
                  v-model="field.phone"
                  id="phone"
                  name="phone"
                ></vue-tel-input>
                <!-- <div class="form-group">
                  <label for="name">
                    <i class="zmdi zmdi-phone-in-talk"></i>
                  </label>
                  <input type="text" name="phone" v-model="field.phone" />
                </div> -->
                <br />
                <div v-if="validation.phone" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
                  {{ validation.phone[0] }}
                </div>
                <br />
                <div class="form-group">
                  <label for="email"><i class="zmdi zmdi-email"></i></label>
                  <input @mousedown="ResetForm"
                    type="text"
                    name="email"
                    id="email"
                    placeholder="Your Email"
                    v-model="field.email"
                  />
                  <div v-if="validation.email" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
                    {{ validation.email[0] }}
                  </div>
                </div>
                <div class="form-group">
                  <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                  <input @mousedown="ResetForm"
                    type="password"
                    name="pass"
                    id="password"
                    placeholder="Password"
                    v-model="field.password"
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
                  <label for="re_pass"
                    ><i class="zmdi zmdi-lock-outline"></i
                  ></label>
                  <input
                    type="password"
                    name="password_confirmation"
                    id="re_password"
                    placeholder="Repeat your password"
                    v-model="field.password_confirmation"
                  />
                 
                </div>
                <div
                  id="show-password"
                  class="show"
                  v-on:click="showPasswordConfirm"
                >
                  <div v-if="showingConfirm === false">
                    <span v-html="show"></span> Show Password
                  </div>
                  <div v-else><span v-html="hide"></span> Hide Password</div>
                </div>
                <br />

                <div class="form-group">
                 <small class="text-danger">
                  Package EasyNet Anda (*Abaikan jika belum berlangganan)
                </small>
                  <select @change="ChangeProduct($event)" class="list-product form-select" aria-label="Default select example" id="product" name="products[]">
                    <option selected>Pilih product easynet</option>
                    <option v-for="(item,index) in products" :value="item.slug" :data-product-id="item.id">
                      {{item.name}}
                    </option>
                  </select>
                  
                  <!-- <pre class='mt-3'>
                    {{product_id}}
                  </pre> -->

                </div>

                <div v-if="show_package"  class="form-group mt-3 mb-3">
                  <div v-if="loading_package" class="d-flex justify-content-center">
                    <div class="spinner-grow text-center text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
                  <div v-else>
                    <small class="text-danger">
                      Pilih package anda (*Abaikan jika belum berlangganan)
                    </small>
                    <select @change="ChangePackage($event)" class="list-product form-select" aria-label="Default select example" id="product" name="packages">
                      <option selected>Pilih package product easynet</option>
                      <option v-for="(item,index) in packages" :value="item.slug" :data-package-id="item.id">
                        {{item.package_name}}
                      </option>
                    </select>
                  </div>
                  <!-- <pre class='mt-3'>
                    {{package_id}}
                  </pre> -->

                </div>

                <div class="form-group">
                  <input
                    type="checkbox"
                    name="agree-term"
                    id="agree-term"
                    class="agree-term"
                    v-model="checked"
                  />
                  <label for="agree-term" class="label-agree-term"
                    ><span><span></span></span>I agree
                    <a href="#" class="term-service">Terms of service</a>
                  </label>
                </div>
                <div class="form-group form-button">
                  <div class="d-grid gap-2">
                    <button class="btn btn-primary rounded-pill" type="submit">
                      <div v-if="loading">
                        <span
                          class="spinner-border spinner-border-sm"
                          role="status"
                          aria-hidden="true"
                        ></span>
                        Loading...
                        <span class="visually-hidden">Loading...</span>
                      </div>
                      <div v-else>Register</div>
                    </button>
                  </div>
                </div>
              </form>
              
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import SignupArt from "@/components/Molecules/Auth/signup";

export default {
  components: {
    SignupArt,
  },
  data() {
    return {
      error: null,
      checked:null,
      show: `<i class="zmdi zmdi-eye"></i>`,
      hide: `<i class="zmdi zmdi-eye-off"></i>`,
      showing: false,
      showingConfirm: false,
      loading: null,
      validation: {},
      ip: '',
      field: {},
      hidden: {
        login: 0,
        roles: ["CUSTOMER"],
        status: "INACTIVE"
      },
      show_package: null,
      products:[],
      product_id: '',
      packages:[],
      package_id: '',
      loading_package: null
    };
  },

  mounted() {
    // this.CheckLocation(),
    this.$axios('https://api.ipify.org/?format=json')
    .then(res => {
      this.ip = res.data.ip
    })
    .catch(err => {
      console.log(err.message)
    }),
    this.Location(),
    this.Products()
  },

  methods: {
    ResetForm(){
      this.error=false
      this.validation=''
    },
    Location(){
      this.$axios.get(`https://ipapi.co/${this.ip}/json`)
      .then(res => {
        this.hidden.city = res.data.city
        this.hidden.region = res.data.region
      })
      .catch(err => console.log(err.message))
    },
    Register() {
      this.loading = true;
      if(!this.checked){
        this.loading=false
        this.$swal({
          icon: 'error',
          title: 'Oops...',
          text: 'Please  checked I agree !',
          footer: ''
        })
      }else{
        const config = {
          baseurl: process.env.BASEURL,
          token: process.env.APITOKEN,
        };
        let field_data = {
          city: this.hidden.city,
          province: this.hidden.region,
          login: this.hidden.login,
          roles: this.hidden.roles,
          status: this.hidden.status,
          name: this.field.name,
          email: this.field.email,
          phone: this.field.phone,
          password: this.field.password,
          password_confirmation: this.field.password_confirmation,
          product_id: this.product_id,
          package_id: this.package_id
        };
        this.$axios
          .post(`${config.baseurl}/register`, {
            name: field_data.name,
            email: field_data.email,
            phone: field_data.phone,
            roles: field_data.roles,
            status: field_data.status,
            photo: null,
            password: field_data.password,
            password_confirmation: field_data.password_confirmation,
            city: field_data.city,
            province: field_data.province,
            login: 0,
            product_id: field_data.product_id,
            package_id: field_data.package_id
          })
          .then((res) => {
            this.loading=false
            this.error=false
            if (res.data.success) {
              this.$swal({
                position: "center",
                icon: "success",
                title: res.data.message,
                showConfirmButton: true,
                timer: 3000,
              });
              localStorage.setItem('register_success', JSON.stringify(res.data))
              setTimeout(() => {
                this.$router.push({
                  path: "/auth/login",
                });
              },2500)
              
            }
          })
          .catch((error) => {
            // console.log(error.response.data
            //set validation dari error response
            this.$swal({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            this.loading=false
            this.error=true
            this.validation = error.response.data;
          });
      }
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
    showPasswordConfirm() {
      const password = document.querySelector("#re_password");
      if (password.type === "password") {
        password.type = "text";
        this.showingConfirm = true;
      } else {
        password.type = "password";
        this.showingConfirm = false;
      }
    },

    CheckLocation() {
      const config = {
        baseurl: process.env.BASEURL,
        token: process.env.APITOKEN,
      };
      this.$axios
        .get(`${config.baseurl}/locator/${config.token}`)
        .then((res) => {
          this.hidden.city = res.data.data.city;
          this.hidden.region = res.data.data.region;
        })
        .catch((err) => {
          console.log(err.message);
        });
    },

    Products(){
      const config = {
        baseurl: process.env.BASEURL,
        token: process.env.APITOKEN,
      };
      this.$axios.get(`${config.baseurl}/product/${config.token}`)
      .then((data) =>  {
        this.products=data.data.data
      })
      .catch((err) => {
        console.log(err.message);
      });
    },

    ChangeProduct(e){
      this.packages=''
      this.show_package=false
      this.loading_package=true
      const config = {
        baseurl: process.env.BASEURL,
        token: process.env.APITOKEN,
      };
      const options = e.target.options
      this.product_id = options[options.selectedIndex].getAttribute('data-product-id')
      const slug = e.target.value
      this.$axios.get(`${config.baseurl}/product/detail/${slug}/${config.token}`)
      .then(response => {
        this.show_package=true
        setTimeout(() => {
          this.packages = response.data.data.packages
          this.loading_package=false
        },1500)
      })
      .catch(err => console.log(err.message))
    },

    ChangePackage(e){
      const options = e.target.options
      this.package_id = options[options.selectedIndex].getAttribute('data-package-id')
    }

  },
};
</script>

<style>
.container-signup {
  background: rgba(255, 255, 255, 0.9);
  opacity: 0.9;
}

.show {
  cursor: pointer;
}
</style>
