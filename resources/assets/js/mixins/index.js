export default {
  methods: {
    toastAlert (type = '', msg = '', title = '') {
      this.$toast[type](msg, title, { close: true, toastOnce: true, position: 'topRight' });
    }
  }
}