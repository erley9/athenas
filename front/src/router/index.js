import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import RegistroView from '../views/RegistroView.vue'
import ClientListView from '../views/ClientListView.vue'
import ClientCadatroView from '../views/ClientCadatroView.vue'
import ClientEditarView from '../views/ClientEditarView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView,
      meta: {
        "requiresAuth":false
      }
    },
    {
      path: '/registro',
      name: 'registro',
      component: RegistroView,
      meta: {
        "requiresAuth":false
      }
    },
    {
      path: '/clientes',
      name: 'clientes',
      component: ClientListView,
      meta: {
        "requiresAuth":true
      }
    },
    {
      path: '/clientes/cadastro',
      name: 'clienteCadastro',
      component: ClientCadatroView,
      meta: {
        "requiresAuth":true
      }
    },
    {
      path: '/clientes/editar/:id',
      name: 'clienteEditar',
      component: ClientEditarView,
      meta: {
        "requiresAuth":true
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (localStorage.getItem("accesstoken") == null) {
      next({ path: '/' })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
