// src/router/index.js

import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Usuarios from '../components/Usuarios.vue';
import Ponto from '../components/Ponto.vue';
import CadastroFuncionario from '../components/CadastroFuncionario.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
  },
  {
    path: '/usuarios',
    name: 'Usuarios',
    component: Usuarios,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/ponto',
    name: 'Ponto',
    component: Ponto,
    meta: { requiresAuth: true },
  },
  {
    path: '/cadastro-funcionario',
    name: 'CadastroFuncionario',
    component: CadastroFuncionario,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Verificação de autenticação
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const userRole = localStorage.getItem('role'); // Supondo que a role esteja armazenada

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!token) {
      next('/');
    } else {
      if (to.matched.some(record => record.meta.requiresAdmin) && userRole !== 'admin') {
        next('/');
      } else {
        next();
      }
    }
  } else {
    next();
  }
});

export default router;

