import Vue from 'vue'
import Router from 'vue-router'
import IndexPage from '@/pages/products/IndexPage'
import ViewProduct from '@/pages/products/ViewProduct'
import Chart from '@/pages/products/Chart'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'IndexPage',
      component: IndexPage
    },
    {
      path: '/product/:id',
      name: 'ViewProduct',
      component: ViewProduct
    },
    {
      path: '/chart',
      name: 'Chart',
      component: Chart
    }
  ]
})
