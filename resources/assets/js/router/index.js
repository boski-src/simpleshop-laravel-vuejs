import Vue from 'vue'
import VueRouter from 'vue-router'

import Auth from '../Auth'
import Home from '../Home'

import Login from '../pages/auth/Login'
import Register from '../pages/auth/Register'

import HomePage from '../pages/HomePage'
import ShoppingCart from '../pages/Cart'
import CategoriesIndex from '../pages/categories/Index'
import CategoriesItem from '../pages/categories/Item'
import Product from '../pages/Product'

import AccountOrders from '../pages/account/Orders'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      children: [
        {
          path: '/',
          name: 'HomePage',
          component: HomePage,
          meta: {
            requireAuth: false,
            title: 'Newest products',
            pretitle: ''
          }
        },
        {
          path: 'cart',
          name: 'ShoppingCart',
          component: ShoppingCart,
          meta: {
            requireAuth: false,
            title: 'Shopping Cart',
            pretitle: ''
          }
        },
        {
          path: 'categories',
          name: 'CategoriesIndex',
          component: CategoriesIndex,
          meta: {
            requireAuth: false,
            title: '',
            pretitle: 'Categories list'
          }
        },
        {
          path: 'categories/:slug',
          name: 'CategoriesItem',
          component: CategoriesItem,
          meta: {
            requireAuth: false,
            title: 'Products',
            pretitle: 'Category'
          }
        },
        {
          path: 'products/:id/:slug?',
          name: 'Product',
          component: Product,
          meta: {
            requireAuth: false,
            title: 'View',
            pretitle: 'Product'
          }
        },
        {
          path: 'account/orders',
          name: 'AccountOrders',
          component: AccountOrders,
          meta: {
            requireAuth: true,
            title: 'My orders',
            pretitle: 'Account'
          }
        }
      ]
    },
    {
      path: '/auth',
      name: 'Auth',
      component: Auth,
      children: [
        {
          path: 'login',
          name: 'Login',
          component: Login,
          meta: {
            authPage: true,
            title: 'Sign In',
          }
        },
        {
          path: 'create',
          name: 'Register',
          component: Register,
          meta: {
            authPage: true,
            title: 'Sign Up',
          }
        }
      ]
    },
    {
      path: '*',
      redirect: '/'
    }
  ]
})

router.beforeEach((to, from, next) => {
  window.scrollTo(0, 0)
  if (to.matched.some(record => record.meta.authPage)) {
    if (localStorage.getItem('user_token')) {
      router.push({name: 'HomePage'})
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.requireAuth)) {
    if (localStorage.getItem('user_token')) {
      next()
    } else {
      next({
        name: 'Login',
        query: {
          redirect: to.fullPath,
        },
      });
    }
  } else {
    next ()
  }
})

export default router