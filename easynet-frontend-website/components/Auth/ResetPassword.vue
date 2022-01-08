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
              <h2 class="form-title">Reset your password</h2>
              <!-- <pre>
                {{token}}
              </pre> -->
              
              <div v-if="show_message">
                <div v-if="success" class="mt-2 mb-3 col-lg-12 col-xs-12 col-sm-12">
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{message}}
                  </div>
                </div>

                <div v-else class="mt-2 mb-3 col-lg-12 col-xs-12 col-sm-12">
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{message}}
                  </div>
                </div>
              </div>

              <form
                @submit.prevent="Reset"
                class="register-form"
                id="register-form"
              >  
              <div class="form-group">
                <input
                type="hidden"
                name="token"
                id="token"
                v-model="token"
                disabled
                autofocus
                />
              </div> 

              <div class="form-group">
                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                <input @mousedown="ResetForm"
                type="password"
                name="pass"
                id="password"
                placeholder="Your New Password Here"
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
                <label for="re_pass"
                ><i class="zmdi zmdi-lock-outline"></i
                  ></label>
                  <input
                  type="password"
                  name="password_confirmation"
                  id="re_password"
                  placeholder="Repeat your new password"
                  v-model="user.password_confirmation"
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
                      <div v-else>Submit</div>
                    </button>
                  </div>
                </div>
              </form>

              
            </div>

            <div class="signup-image">
              <figure>
                <SignupArt />
              </figure>
              <nuxt-link to="/auth/login" class="signup-image-link"
                >Kembali ke ? (Login disini)</nuxt-link
              >
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
      token: this.$route.params.token,
      loading: null,
      user: {},
      validation:{},
      error: null,
      success: null,
      error_token: null,
      message: null,
      show_message: false,
      ready: null,
      show: `<i class="zmdi zmdi-eye"></i>`,
      hide: `<i class="zmdi zmdi-eye-off"></i>`,
      showing: false,
      showingConfirm: false
    }
  },

  methods: {
    ResetForm(){
      this.error=false
      this.validation=''
    },
    Reset(){
      this.loading = true
      this.$axios.post(`${process.env.BASEURL}/reset`,{
        'token': this.token,
        'password': this.user.password,
        'password_confirmation': this.user.password_confirmation
      })
      .then((res) => {
        console.log(res)
        this.validation={}
        if(res.data.success){
          this.user = {}
            this.$swal({
              position: "center",
              icon: "success",
              title: res.data.message,
              showConfirmButton: true,
              timer: 3000,
            });
           this.loading=false
           this.show=true
           this.success=true
           this.message=res.data.message
           setTimeout(() => {
            this.$router.push({
              path: "/auth/login",
            });
          },2500)
        }
        
      })

      .catch((err) => {
        console.log(err.response.data)
        this.loading=false
        this.show = false
        this.success = false
        this.error=true
        this.$swal({
          icon: 'error',
          title: 'Oops...',
          text: err.response.data.message
        })
        this.user = {}
        this.validation = err.response.data
      })
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
    }

  }
}
</script>

<style>
.container-signin {
  background: rgba(255, 255, 255, 0.9);
  opacity: 0.9;
}
</style>
