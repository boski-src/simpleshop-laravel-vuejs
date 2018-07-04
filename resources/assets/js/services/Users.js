import Api from './Api'

export default {
  Login (credentials) {
    return Api().post('auth/login', credentials);
  },
  Create (credentials) {
    return Api().post('auth/create', credentials);
  },
  Me () {
    return Api().get('auth/me');
  },
  Logout () {
    return Api().get('auth/logout');
  }
}
