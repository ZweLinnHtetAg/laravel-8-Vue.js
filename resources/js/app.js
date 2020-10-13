
require('./bootstrap');

import { Form, HasError, AlertError } from 'vform'
import Swal from 'sweetalert2'
import VueProgressBar from 'vue-progressbar'
import Loading from 'vue-loading-overlay';

window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-start',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Vue = require('vue');
window.Form = Form;
window.Toast = Toast;

const options = {
    color: '#3490dc',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.1s',
      opacity: '1s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
  }
  
Vue.use(VueProgressBar, options)
Vue.use(Loading,{color : "#3490dc",});
Vue.component('loading',Loading);
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);


const app = new Vue({
    el: '#app',
});
