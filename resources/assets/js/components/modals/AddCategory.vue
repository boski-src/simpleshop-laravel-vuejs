<template>
  <div
          class="modal fade"
          id="addCategory"
          tabindex="-1"
          role="dialog"
          aria-labelledby="addCategoryLabel"
          aria-hidden="true"
  >
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryLabel">Add category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-1">
              <label class="grey-text">Name</label>
              <input
                      name="name"
                      type="text"
                      class="form-control"
                      v-model="addCategory.name"
                      v-validate="'required|min:1|max:150'"
              >
              <span class="text-danger small">{{ errors.first('name') }}</span>
            </div>
            <div class="col-md-6 mb-2">
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
                  @click="createCategory"
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
  import { mapGetters, mapActions } from 'vuex'
  import mixin from '../../mixins/index'
  import CategoryService from '../../services/Categories'

  export default {
    name: 'AddCategory',
    mixins: [mixin],
    data: () => ({
      addCategory: {
        name: '',
        image: ''
      }
    }),
    methods: {
      ...mapActions(['getCategories']),
      onImageChange (e) {
        let files = e.target.files || e.dataTransfer.files
        if (!files.length) return false
        this.createImage(files[0])
      },
      createImage (file) {
        let reader = new FileReader()
        reader.onload = (e) => {
          this.addCategory.image = e.target.result
        }
        reader.readAsDataURL(file)
      },
      createCategory () {
        this.$validator.validateAll().then(result => {
          if (!result) return this.toastAlert('info', 'Please fill correctly all fields.')
          CategoryService.create(this.addCategory)
            .then(response => response.data)
            .then(response => {
              if (response.success) {
                this.addCategory = { name: '', image: '' }
                this.toastAlert('success', 'Category successfully created!')
                this.getCategories()
              }
            })
        });
      }
    }
  }
</script>