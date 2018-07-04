import axios from 'axios'
import store from '../store'

export default () => {
  const instance = axios.create({
    baseURL: '/api',
    timeout: 10000,
    headers: {
      'Authorization': 'Bearer ' + localStorage.getItem('user_token')
    }
  })

  instance.interceptors.response.use(response => response, error => {
    let status = error.response.status;

    if (status === 401) {
      store.dispatch('logout')
    } else if (status === 429) {}

    return error.response
  })

  return instance
}
