<template>
  <div
          class="modal fade"
          id="addProduct"
          tabindex="-1"
          role="dialog"
          aria-labelledby="addProductLabel"
          aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductLabel">Add product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-2">
              <label class="grey-text">Name</label>
              <input
                      name="name"
                      type="text"
                      class="form-control"
                      v-model="addProduct.name"
                      v-validate="'required|min:1|max:64'"
              >
              <span class="text-danger small">{{ errors.first('name') }}</span>
            </div>

            <div class="col-md-12 mb-2">
              <label class="grey-text">Description</label>
              <textarea
                      name="description"
                      type="text"
                      class="form-control"
                      rows="3"
                      v-model="addProduct.description"
                      v-validate="'required|min:3'"
              ></textarea>
              <span class="text-danger small">{{ errors.first('description') }}</span>
            </div>

            <div class="col-md-6">
              <label class="grey-text">Price</label>
              <input
                      name="price"
                      type="number"
                      class="form-control"
                      v-model="addProduct.price"
                      step="0.01"
                      v-validate="'required|decimal|min:1'"
              >
              <span class="text-danger small">{{ errors.first('price') }}</span>
            </div>

            <div class="col-md-6">
              <label class="grey-text">Available</label>
              <input
                      name="available"
                      type="number"
                      class="form-control"
                      v-model="addProduct.available"
                      min="1"
                      max="99999"
                      v-validate="'required|integer|min:1|max:99999'"
              >
              <span class="text-danger small">{{ errors.first('available') }}</span>
            </div>

            <div class="col-md-6">
              <label class="grey-text">Category</label>
              <select
                      name="category"
                      class="form-control"
                      v-validate="'required|min:1'"
                      v-model="addProduct.category_id"
                      @click.native="fetchCategories"
              >
                <option value="-1" selected>- Select a Category -</option>
                <option
                        v-for="category in categories"
                        :value="category.id"
                >
                  {{ category.name }}
                </option>
              </select>
              <span class="text-danger small">{{ errors.first('category') }}</span>
            </div>

            <div class="col-md-6">
              <label class="grey-text">Image</label>
              <input type="file" class="form-control" @change="onImageChange">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
                  type="button"
                  class="btn btn-primary"
                  data-dismiss="modal"
                  @click="createProduct"
          >
            Create
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import mixin from '../../mixins/index'
  import ProductService from '../../services/Products'

  export default {
    name: 'AddProduct',
    mixins: [mixin],
    computed: mapGetters({categories: 'getCategories'}),
    data: () => ({
      addProduct: {
        name: '',
        description: '',
        price: 10,
        available: 1,
        category_id: -1,
        image: ''
      }
    }),
    methods: {
      onImageChange (e) {
        let files = e.target.files || e.dataTransfer.files
        if (!files.length) return false
        this.createImage(files[0])
      },
      createImage (file) {
        let reader = new FileReader()
        reader.onload = (e) => {
          this.addProduct.image = e.target.result
        }
        reader.readAsDataURL(file)
      },
      createProduct () {
        this.$validator.validateAll().then(result => {
          if (!result) return this.toastAlert('info', 'Please fill correctly all fields.')
          ProductService.create(this.addProduct)
            .then(response => response.data)
            .then(response => {
              if (response.success) {
                this.addProduct = {
                  name: '',
                  description: '',
                  price: 10,
                  available: 1,
                  category_id: -1,
                  image: ''
                }
                this.toastAlert('success', 'Product successfully created!')
              }
            })
        });
      }
    }
  }
</script>