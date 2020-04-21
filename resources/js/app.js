/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';
import Swal from 'sweetalert2'
window.Swal=Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast=Toast;


window.Form=Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes = [
    { path: '/dashboard', component: require('./components/dashboard.vue').default },
    { path: '/salesstaff', component: require('./components/salesstaff.vue').default  },
    { path: '/artist', component: require('./components/artist.vue').default  },
    { path: '/producer', component: require('./components/producer.vue').default  },
    { path: '/statistics', component: require('./components/statistics.vue').default  },
    { path: '/users', component: require('./components/users.vue').default  },
    { path: '/managealbums', component: require('./components/managealbums.vue').default  }
  ]

  const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

  Vue.filter('mydate',function(date){
      return moment(date).format('MMMM Do YYYY');
  });

window.Fire=new Vue();

 
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    router: router,
    data:{
      search:''
    },
    methods:{
      searchit: _.debounce(()=>{
        Fire.$emit('searching');
      },500)
    }
   
});
