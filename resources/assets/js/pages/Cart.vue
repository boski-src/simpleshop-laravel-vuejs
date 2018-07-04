<template>
  <div class="col-md-12 my-3 px-0">
    <div class="table-responsive" v-if="step === 1">
      <table class="table table-hover text-center" v-if="basketProducts.length">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product, index) in basketProducts">
            <td>{{ index + 1 }}.</td>
            <td class="font-weight-bold">
              <router-link :to="{ name: 'Product', params: { id: product.id, slug: product.slug } }">{{ product.name }}</router-link>
            </td>
            <td>{{ product.quantity }}</td>
            <td><b>{{ product.quantity * product.price }}$</b> ({{ product.price }}$)</td>
            <td>
              <button
                    type="button"
                    class="btn btn-sm btn-primary px-3 my-0"
                    @click="addToBasket(product)"
              >
                <i class="fa fa-plus" aria-hidden="true"></i>
              </button>
              <button
                    type="button"
                    class="btn btn-sm btn-primary px-3 my-0"
                    @click="removeFromBasket({product: product, soft: false})"
              >
                <i class="fa fa-minus" aria-hidden="true"></i>
              </button>
              <button
                    type="button"
                    class="btn btn-sm btn-danger px-3 my-0"
                    @click="removeFromBasket({product: product, soft: true})"
              >
                <i class="fa fa-remove" aria-hidden="true"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="alert alert-info text-center font-weight-bold" v-else>Cart is empty :(</div>
      <template v-if="basketProducts.length">
        <button type="button" class="btn btn-primary float-right" @click="nextStep">
          NEXT STEP
        </button>
        <h3><b>Total Price:</b> {{ basketPrice }}$</h3>
      </template>
      <template v-else>
        <router-link class="btn btn-primary float-right" :to="{ name: 'CategoriesIndex' }">
          Continue <b>Shopping</b>
        </router-link>
      </template>
    </div>
    <div v-else-if="step === 2">
      <form class="row">
        <div class="col-md-6" v-for="data in billingForm">
          <label class="grey-text">{{ data.label }}</label>
          <input
                  :name="data.name"
                  :type="data.type"
                  class="form-control"
                  v-model="billingData[data.name]"
                  v-validate="data.validate"
                  v-if="data.type === 'text' || data.type === 'email'"
          >
          <textarea
                  :name="data.name"
                  class="form-control"
                  v-model="billingData[data.name]"
                  v-validate="data.validate"
                  v-else-if="data.type === 'textarea'"
          ></textarea>
          <span class="text-danger small">{{ errors.first(data.name) }}</span>
        </div>
      </form>
      <button type="button" class="btn btn-primary" @click="step = 1">
        BACK
      </button>
      <button type="button" class="btn btn-primary float-right" @click="order">
        Order
      </button>
    </div>
    <div v-else-if="step === 3">
      <div class="loader">
        <half-circle-spinner
                :animation-duration="1300"
                :size="100"
                color="#4285f4"
        />
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import mixin from '../mixins/index'
  import { HalfCircleSpinner } from 'epic-spinners'
  import OrderService from '../services/Orders'

  export default {
    mixins: [mixin],
    components: {
      HalfCircleSpinner
    },
    computed: mapGetters({
      basketPrice: 'getPrice',
      basketProducts: 'getProducts',
      logged: 'getLogged'
    }),
    data: () => ({
      step: 1,
      billingForm: [
        {label: 'First name', name: 'firstName', type: 'text', validate: 'required'},
        {label: 'Last name', name: 'lastName', type: 'text', validate: 'required'},
        {label: 'Phone', name: 'phone', type: 'text', validate: 'required'},
        {label: 'Country', name: 'country', type: 'text', validate: 'required'},
        {label: 'City', name: 'city', type: 'text', validate: 'required'},
        {label: 'Street', name: 'street', type: 'text', validate: 'required'},
        {label: 'Email', name: 'email', type: 'email', validate: 'required|email'},
        {label: 'Zip code', name: 'zipcode', type: 'text', validate: 'required'},
        {label: 'Description', name: 'description', type: 'textarea', validate: ''}
      ],
      billingData: {
        firstName: '',
        lastName: '',
        phone: '',
        country: '',
        city: '',
        street: '',
        email: '',
        zipcode: '',
        description: ''
      }
    }),
    methods: {
      ...mapActions(['addToBasket', 'removeFromBasket', 'clearBasket']),
      nextStep () {
        if (!this.logged) {
          this.toastAlert('warning', 'You have to sign in first!')
          this.$router.push({name: 'Login', query: {redirect: this.$route.path}})
        }
        this.step++
      },
      async order () {
        this.$validator.validateAll().then(result => {
          if (!result) return this.toastAlert('info', 'Please fill correctly all fields.')
          OrderService.create(this.basketProducts, this.billingData)
            .then(response => response.data)
            .then(response => {
              if (response.success) {
                this.step++
                this.clearBasket()
                setTimeout(() => {
                  this.toastAlert('info', 'Click "pay" button to pay new order.')
                  this.$router.push({name: 'AccountOrders'})
                }, 2000)
              } else {
                return this.toastAlert('warning', 'Try again, later.')
              }
            })
        })
      }
    }
  }
</script>
