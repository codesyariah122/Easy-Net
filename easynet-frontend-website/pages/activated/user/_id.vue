<template>
  <div>
    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <br />
        <center>
          <img
            class="logo1"
            src="/assets/images/logo/logo-blue.svg"
            width="200"
          />
          <h1 class="display-5 fw-bold mt-5">Activated User</h1>
        </center>

        <blockquote>
          {{ context.message }}
        </blockquote>

        <small class="text-info mt-5 mb-5 text-justify">
          {{ context.target }}
        </small>
        <br />
        <br />
        <!-- <form @submit.prevent="Activation">
          <input type="hidden" name="id" v-model="id" />
          <input type="hidden" name="status" v-model="field.status" />
          <button type="submit" class="btn btn-primary btn-lg">
            Aktivasi Akun
          </button>
        </form> -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "activation",
  head: {
    titleTemplate: "EasyNet - Activated",
  },
  data() {
    return {
      loading: null,
      field: {
        id: this.$route.params.id ? this.$route.params.id : "",
        status: "ACTIVE",
      },
      context: [],
    };
  },

  mounted() {
    this.CheckActivatedUser(this.field.id);
    // this.Activation(this.field.id, this.field.status)
  },

  methods: {
    CheckActivatedUser(id) {
      const config = {
        baseurl: process.env.BASEURL,
        token: process.env.APITOKEN,
      };
      this.$axios
        .get(`${config.baseurl}/check-activated/${id}/${config.token}`)
        .then((res) => {
          this.loading = true;
          // console.log(res.data);
          if (res.data.ready) {
            this.$swal({
              position: "center",
              icon: "success",
              title: "User is active",
              showConfirmButton: false,
              timer: 1500,
            });
            localStorage.removeItem('register_success')
            setTimeout(() => {
              this.$router.push({ path: "/" });
            }, 1500);
            // setTimeout(function(){
            // 	window.close() ? window.close : this.$router.push({path: '/'})
            // },1500)
          } else {
            this.Activation(this.field.id, this.field.status);
          }

          this.loading = false;
          this.context = res.data;
        })
        .catch((err) => {
          this.loading = false;
          console.log(err.response.data);
        });
    },

    Activation(id, status) {
      const config = {
        baseurl: process.env.BASEURL,
        token: process.env.APITOKEN,
      };
      this.$axios
        .put(`${config.baseurl}/activated/${id}/${config.token}`, {
          id: id,
          status: status,
        })
        .then((res) => {
          console.log(res.data);
          if (res.data.success) {
            this.$swal({
              position: "center",
              icon: "success",
              title: res.data.message,
              showConfirmButton: true,
              timer: 2500,
            });
            localStorage.removeItem('register_success')
            setTimeout(() => {
              this.$router.push({ path: "/auth/login" });
            }, 1500);
          }
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
  },
};
</script>
