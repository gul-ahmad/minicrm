/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue').default;
 
 import VueRouter from 'vue-router'
 Vue.use(VueRouter)
 
 import Form from 'vform';
 
 import {
     Button,
     HasError,
     AlertError,
     AlertErrors,
     AlertSuccess
   } from 'vform/src/components/bootstrap4'
 
 Vue.component(Button.name, Button)
 Vue.component(HasError.name, HasError)
 Vue.component(AlertError.name, AlertError)
 Vue.component(AlertErrors.name, AlertErrors)
 Vue.component(AlertSuccess.name, AlertSuccess)

 Vue.component('pagination', require('laravel-vue-pagination'));
 
 
 
 import VueProgressBar from 'vue-progressbar'
 const options = {
     color: '#bffaf3',
     failedColor: '#874b4b',
     thickness: '8px',
     transition: {
       speed: '0.50s',
       opacity: '0.6s',
       termination: 300
     },
     autoRevert: true,
     location: 'top',
     inverse: false
   }
   
   Vue.use(VueProgressBar, options)
 
   import Swal from 'sweetalert2'
    window.Swal =Swal;
 
 /**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
  */
 
 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
 
 //Vue.component('example-component', require('./components/ExampleComponent.vue').default);
 //Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);
 
 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */
  const routes = [
     { path: '/dashboard', component: require('./components/DashboardComponent.vue').default },
     { path: '/companies', component: require('./components/Companies.vue').default },
     { path: '/employees', component: require('./components/Employees.vue').default }
   

 
 
   ]
   
   // 3. Create the router instance and pass the `routes` option
   // You can pass in additional options here, but let's
   // keep it simple for now.
   const router = new VueRouter({
     routes, // short for `routes: routes`
     mode: 'history' //added history mode for the issue of Unfriendly URLs
   })
 
 
 


 
 
 
 
 const app = new Vue({
     el: '#app',
     router
 });
 