<template>
  <div
          class="modal fade"
          id="DisplayOrder"
          tabindex="-1"
          role="dialog"
          aria-labelledby="DisplayOrderLabel"
          aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <template v-if="data.items.length">
          <div class="modal-header">
            <h5 class="modal-title" id="DisplayOrderLabel">Order details: <b>{{ data.hash }}</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <!--<div class="col-md-12" v-if="userPrivilege > 0">-->
              <!--</div>-->
              <div class="col-md-6">
                <h4>Billing data:</h4>
                <p>
                  {{ data.billing.firstName }} {{ data.billing.lastName }}<br>
                  <b>Street:</b> {{ data.billing.street }}<br>
                  {{ data.billing.zipcode }} {{ data.billing.city }}<br>
                  <b>Phone:</b> {{ data.billing.phone }}<br>
                  <b>Email:</b> <a :href="'mailto:' + data.billing.email">{{ data.billing.email }}</a>
                </p>
              </div>
              <div class="col-md-6">
                <h4>Products ({{ data.items.length }}): {{ data.price }}$</h4>
                <ul>
                  <li v-for="product in data.items">
                    <router-link :to="{ name: 'Product', params: { id: product.id } }">
                      ({{ product.id }})
                    </router-link>
                    ∗
                    {{ product.count }}
                    =
                    <span><b>{{ product.price }}$</b></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="text-center">
            <div class="loader">
              <half-circle-spinner
                      :animation-duration="1300"
                      :size="30"
                      color="#4285f4"
              />
            </div>
          </div>
        </template>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import mixin from '../../mixins/index'
  import { HalfCircleSpinner } from 'epic-spinners'
  import OrderService from '../../services/Orders'

  export default {
    name: 'DisplayOrder',
    mixins: [mixin],
    components: {
      HalfCircleSpinner
    },
    computed: mapGetters({
      categories: 'getCategories',
      userPrivilege: 'getUserPrivilege'
    }),
    props: {
      data: {
        type: Object,
        required: true
      }
    }
  }
</script>