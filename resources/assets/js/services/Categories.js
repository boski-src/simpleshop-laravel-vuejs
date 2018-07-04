import Api from './Api'

export default {
  fetchAll () {
    return Api().get('categories');
  },
  fetchProducts (slug, page = 1) {
    return Api().get(`categories/${slug}?page=${page}`);
  },
  create (params) {
    return Api().post('categories', params);
  },
  update (slug, params) {
    return Api().put(`categories/${slug}`, params);
  },
  delete (slug) {
    return Api().delete(`categories/${slug}`);
  }
}
