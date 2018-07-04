<template>
  <div>
    <template v-if="orders.data.length">
      <div class="table-responsive">
        <table class="table table-hover table-sm text-center">
          <thead>
          <tr>
            <th>Order Hash</th>
            <th>Paid</th>
            <th>IPN</th>
            <th>Last action</th>
            <th>Status</th>
            <th v-if="userPrivilege > 0">
              <button
                      class="btn btn-sm btn-secondary my-0 py-1"
                      v-if="!admin"
                      @click="fetchAdmin"
              >Admin
              </button>
              <button
                      class="btn btn-sm btn-secondary my-0 py-1"
                      v-else-if="admin"
                      @click="fetchUser"
              >User
              </button>
            </th>
            <th v-else>Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="order in orders.data" class="small">
            <td><a :title="order.hash">{{ order.hash.slice(15) }}...</a></td>
            <td>
              <b>{{ order.paid }}</b>
            </td>
            <td>
              <b v-if="order.payment_status">{{ order.payment_status }}</b>
              <b v-else>No</b>
            </td>
            <td>{{ order.updated_at }}</td>
            <td>
              <template v-if="userPrivilege > 0">
                <select class="form-control form-control-sm" v-model="order.status" @change="updateOrder(order.id)" :key="order.id">
                  <option value="new">New</option>
                  <option value="pending">Pending</option>
                  <option value="canceled">Canceled</option>
                  <option value="completed">Completed</option>
                </select>
              </template>
              <template v-else>
                <label
                        class="badge badge-secondary"
                        v-if="order.status === 'new'"
                > {{ order.status }} </label>
                <label
                        class="badge badge-info"
                        v-else-if="order.status === 'pending'"
                > {{ order.status }} </label>
                <label
                        class="badge badge-danger"
                        v-else-if="order.status === 'canceled'"
                > {{ order.status }} </label>
                <label
                        class="badge badge-success"
                        v-else-if="order.status === 'completed'"
                > {{ order.status }} </label>
              </template>
            </td>
            <td>
              <button
                      type="button"
                      class="btn btn-sm btn-warning px-3 my-0"
                      v-if="order.status === 'new'"
                      @click="payOrder(order.hash)"
              >
                PAY
              </button>
              <button
                      type="button"
                      class="btn btn-sm btn-primary px-3 my-0"
                      data-toggle="modal"
                      data-target="#DisplayOrder"
                      @click="fetchOrder(order.hash)"
              >
                <i class="fa fa-eye" aria-hidden="true"></i>
              </button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <pagination :paginator="orders"/>
      <display-order :data="order"/>
    </template>
    <template v-else>
      <div class="col-md-12 text-center my-4">
        <h2>No orders for page: {{ $route.query.page }}</h2>
      </div>
    </template>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  import mixin from '../../mixins/index'
  import OrderService from '../../services/Orders'
  import DisplayOrder from '../../components/modals/DisplayOrder'
  import Pagination from '../../components/Pagination'

  export default {
    name: 'orders',
    mixins: [mixin],
    components: {
      DisplayOrder,
      Pagination
    },
    computed: mapGetters({
      userPrivilege: 'getUserPrivilege'
    }),
    data: () => ({
      order: {
        billing: {},
        items: []
      },
      orders: {
        data: []
      },
      admin: false
    }),
    mounted () {
      this.fetchUser()
    },
    methods: {
      fetchOrder (hash) {
        this.order = {billing: {}, items: []}
        OrderService.fetch(hash)
          .then(response => response.data)
          .then(response => {
            if (!response.success) return false
            this.order = response.data
            this.order.billing = JSON.parse(this.order.billing)
          })
      },
      fetchUser () {
        OrderService.fetchAll(this.$route.query.page)
          .then(response => response.data)
          .then(response => {
            if (!response.success) return false
            this.orders = response.data
            this.admin = false
          })
      },
      fetchAdmin () {
        OrderService.fetchAllAdmin(this.$route.query.page)
          .then(response => response.data)
          .then(response => {
            if (!response.success) return false
            this.orders = response.data
            this.admin = true
          })
      },
      payOrder (hash) {
        return window.location.href = '/api/payment/' + hash
      },
      updateOrder (id) {
        let order = this.orders.data.find(item => item.id === id)
        OrderService.update(order.id, order)
          .then(response => response.data)
          .then(response => {
            if (!response.success) {
              return this.toastAlert('error', 'There was an error while updating the order.')
            }
          })
      }
    }
  }
</script>

<style scoped>

</style>