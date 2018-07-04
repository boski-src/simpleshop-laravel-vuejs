import Api from './Api'

export default {
  fetchAll (page = 1, limit = 10) {
    return Api().get(`orders?page=${page}&limit=${limit}`);
  },
  fetchAllAdmin (page = 1, limit = 10) {
    return Api().get(`orders/all?page=${page}&limit=${limit}`);
  },
  fetch (hash) {
    return Api().get(`orders/${hash}`);
  },
  create (products, billing) {
    return Api().post('orders', {products, billing});
  },
  payment (hash) {
    return Api().get(`payment/${hash}`);
  },
  update (hash, params) {
    return Api().put(`orders/${hash}`, params);
  },
  delete (hash) {
    return Api().delete(`orders/${hash}`);
  }
}
