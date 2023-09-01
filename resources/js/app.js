import './bootstrap';
import $ from 'jquery';


//import 'c:/xampp/htdocs/laravel-vues/resources/sass/app.scss';


//window._ = require('lodash');
import Toaster from '@meforma/vue-toaster'
import 'admin-lte/plugins/jquery/jquery.min.js';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import emitter from './eventLoader.js';
import suppliers from './components/suppliers/add.vue'
import items from './components/items/new.vue'
import category from './components/items/categories.vue'
import department from './components/departments/add.vue'


import { createApp } from 'vue/dist/vue.esm-bundler.js';

import { createRouter, createWebHistory } from 'vue-router';


import LoaderComponent from './components/LoaderComponent.vue'



const routes = [

  { path: '/suppliers', component: suppliers },
  {path:'/items' , component:items},
  {path:'/category', component:category},
  {path:'/departments',component:department}

];


const app = createApp({});

//var Emitter = require('tiny-emitter')
//window.emitter = new Emitter()
//export const emitter = new Emitter();
app.config.globalProperties.$emitter = emitter;

window.jQuery = window.$ = $
//window.Dropzone = Dropzone

const router = createRouter({
  history: createWebHistory(),
  routes,
});


app.component('loader-component', LoaderComponent)

app.use(router);
app.mount('#app');
app.use(Toaster)