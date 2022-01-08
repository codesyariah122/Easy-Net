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
              <h2 class="form-title">Lost your password</h2>
              <div v-if="show">

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
                @submit.prevent="Forgot"
                class="register-form"
                id="register-form"
              >      
                <div class="form-group">
                  <label for="email"><i class="zmdi zmdi-email"></i></label>
                  <input
                    type="text"
                    name="email"
                    id="email"
                    placeholder="Your EasyNet Email"
                    v-model="user.email"
                    autofocus
                  />

                    <div v-if="validation.email" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
                      {{ validation.email[0] }}
                    </div>
                  <br />
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
      loading: null,
      user: {},
      validation:{},
      error: null,
      success: null,
      message: null,
      show: false,
      ready: null
    }
  },

  methods: {
    Forgot(){
      this.loading=true
      this.$axios.post(`${process.env.BASEURL}/forgot`, {
        'email': this.user.email
      })
      .then((res) => {
        this.user.email=''
        this.validation={}
        if(res.data.ready){
          this.loading=false
          this.show=true
          this.ready=true
          this.message=res.data.message
        }
        if(res.data.success){
          this.loading=false
          this.show=true
          this.success = true
          this.message = res.data.message
        }else{
          this.loading=false
          this.show=true
          this.success = false
          this.message = res.data.message
        }
      })
      .catch((err) => {
        console.log(err.response)
        this.loading=false
        this.show = false
        this.success = false
        this.error=true
        this.validation = err.response.data
      })
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
