
require('./bootstrap');
window.Vue = require('vue').default;
// helpers
require('./helpers/filter')
// moment
import moment from 'moment';
// progress bar
import VueProgressBar from 'vue-progressbar'

const progressbarOptions = {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  thickness: '5px',
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.use(VueProgressBar, progressbarOptions)

// sweetalert
import swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'
window.swal = swal
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  })
  window.toast = toast

// custom event
window.Fire = new Vue();

// vform
import Form from 'vform';
window.Form = Form;
import {
    HasError,
    AlertError,
  } from 'vform/src/components/bootstrap4'
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
// vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import routes from './router/index';

const router = new VueRouter({
    routes,
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    router,

});
