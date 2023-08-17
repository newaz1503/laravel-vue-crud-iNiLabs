// capitalize text
Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  })
  // format date
  Vue.filter('formatDate', function (value) {
    return moment(value).format('ll');
  })
