import './bootstrap.js';
import $ from 'jquery';


import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

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
import issue from './components/items/issue.vue'
import staff from './components/staff/add.vue'
import dashboard from './components/items/dashboard.vue'
import itemUnits from './components/items/units.vue'
import dailyIssue from './components/items/daily.vue'


import { createApp } from 'vue/dist/vue.esm-bundler.js';
import DataTablesPlugin from './dataTablesPlugin.js';
import { createRouter, createWebHistory } from 'vue-router';


import LoaderComponent from './components/LoaderComponent.vue'
import MyloaderComponent from './components/MyloaderComponent.vue'



const routes = [

  { path: '/1/suppliers', component: suppliers },
  {path:'/1/items' , component:items},
  {path:'/1/category', component:category},
  {path:'/1/departments',component:department},
  {path:'/1/issueItems',component:issue},
  {path:'/1/staff',component:staff},
  {path:'/',component:dashboard},
  {path:'/1/units',component:itemUnits},
  {path:'/1/todayIssue',component:dailyIssue}


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

app.use(DataTablesPlugin);
app.component('loader-component', LoaderComponent)
app.component('myloader-component', MyloaderComponent)

app.component("v-select", vSelect);



app.use(router);
app.mount('#app');
app.use(Toaster)