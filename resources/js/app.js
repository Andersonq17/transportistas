
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment'; //para el formato de las fechas
import VueProgressBar from 'vue-progressbar' //barra de progreso
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

Vue.component('pagination', require('laravel-vue-pagination')); //paginacion

import Gate from "./gate";
Vue.prototype.$gate = new Gate(window.user);// usar el prototipo en cualquier parte de la app


import { Form, HasError, AlertError } from 'vform'//manejo de errores en formularios
import swal from 'sweetalert2'//sweetalert
window.swal=swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast= toast;


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'


Vue.use(VueRouter)

let routes = [
    { path: '/escritorio', component: require('./components/Escritorio.vue')},
    { path: '/perfil', component: require('./components/Perfil.vue')},
    { path: '/usuarios', component: require('./components/Usuarios.vue')},
    { path: '/dev', component: require('./components/Desarrollador.vue')},
    { path: '/personas', component: require('./components/Personas.vue')},
    { path: '/sindicatos', component: require('./components/Sindicatos.vue')},
    { path: '/lineas', component: require('./components/Lineas.vue')},
    { path: '/unidades', component: require('./components/Unidades.vue')},
    { path: '/reportes', component: require('./components/Reportes.vue')},
    { path: '/proveedores', component: require('./components/Proveedores.vue')},
    { path: '/insumos', component: require('./components/Insumos.vue')},
    { path: '*', component: require('./components/404.vue')}
  ]

  const router = new VueRouter({
      mode: 'history',
    routes // short for `routes: routes`
  })

  Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
  })

  Vue.filter('fechas',function(created){
    return moment(created).format('MMMM Do YYYY, h:mm:ss a');             
  })

  window.Fire= new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('not-found', require('./components/404.vue'));
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue')
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#app',
    router,
     data:{
       buscar:''

     },

     methods:{
       busca: _.debounce(()=>{
        Fire.$emit('buscando');
       },1500)
         
       
     }
});
