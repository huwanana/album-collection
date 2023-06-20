require('./bootstrap');

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './vue/App.vue'
import Home from './vue/Home.vue'
import Create from './vue/Create.vue'
import Show from './vue/Show.vue'
import Edit from './vue/Edit.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/create',
    name: 'Create',
    component: Create
  },
  {
    path: '/:id',
    name: 'Show',
    component: Show,
    props: true
  },
  {
    path: '/:id/edit',
    name: 'Edit',
    component: Edit,
    props: true
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

createApp(App).use(router).mount('#app')