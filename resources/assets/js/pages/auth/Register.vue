<template>
  <div class="col-md-6">
    <div class="card mx-xl-5">
      <div class="card-body">
        <div class="form-header warm-flame-gradient rounded text-center">
          <h3><i class="fa fa-lock"></i> {{ $route.meta.title }}</h3>
        </div>
        <div class="mt-5">
          <label class="grey-text font-weight-light">Name</label>
          <input
                  v-validate="'required|min:3|max:255'"
                  name="name"
                  type="text"
                  class="form-control"
                  v-model="credentials.name"
          >
          <span class="text-danger small">{{ errors.first('name') }}</span>
          <br>
          <label class="grey-text font-weight-light">E-mail</label>
          <input
                  v-validate="'required|email'"
                  name="email"
                  type="email"
                  class="form-control"
                  v-model="credentials.email"
          >
          <span class="text-danger small">{{ errors.first('email') }}</span>
          <br>
          <label class="grey-text font-weight-light">Password</label>
          <input
                  v-validate="{ is: confirmation, required: true, min: 6 }"
                  name="password"
                  type="password"
                  class="form-control"
                  v-model="credentials.password"
          >
          <span class="text-danger small">{{ errors.first('password') }}</span>
          <br>
          <label class="grey-text font-weight-light">Repeat Password</label>
          <input
                  name="password_confirmation"
                  type="password"
                  class="form-control"
                  v-model="confirmation"
          >
          <span class="text-danger small">{{ errors.first('password') }}</span>
          <div class="text-center mt-4">
            <button class="btn btn-primary waves-effect waves-light" @click="create">Sign Up</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="options font-weight-light">
          <p>Back to
            <router-link :to="{name: 'HomePage'}">Home Page</router-link>
          </p>
          <p>Already member?
            <router-link :to="{name: 'Login'}">Sign In</router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import mixin from '../../mixins/index'

  export default {
    mixins: [mixin],
    data: () => ({
      confirmation: '',
      credentials: {
        name: '',
        email: '',
        password: ''
      }
    }),
    methods: {
      create () {
        this.$validator.validate().then(result => {
          if (!result) return this.toastAlert('info', 'Please fill correctly all fields.')
          this.$store.dispatch('create', this.credentials)
        });
      }
    }
  }
</script>

<style scoped>

</style>