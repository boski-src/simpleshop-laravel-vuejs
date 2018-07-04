import Api from './Api'

export default {
  fetchNewest () {
    return Api().get('products');
  },
  fetch (slug) {
    return Api().get(`products/${slug}`);
  },
  search (keyword) {
    return Api().post('products/search', {keyword});
  },
  create (params) {
    return Api().post('products', params);
  },
  update (slug, params) {
    return Api().put(`products/${slug}`, params);
  },
  delete (slug) {
    return Api().delete(`products/${slug}`);
  }
}
