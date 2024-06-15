<template>
  <header>
    <nav>
      <ul>
        <li class="logout__link" v-if="isAuthenticated" @click="logout">Logout</li>
        <li v-else><router-link to="/login">Login</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../services/api';

export default {
  setup() {
    const isAuthenticated = ref(localStorage.getItem('token') !== null);
    const router = useRouter();

    // Verifica a cada mudança de rota se o usuário está autenticado
    router.afterEach(() => {
      isAuthenticated.value = localStorage.getItem('token') !== null;
    });

    const logout = async () => {
      try {
        await api.post('/logout');
        localStorage.removeItem('token');
        isAuthenticated.value = false;
        router.push('/'); // Redireciona para a rota de login
      } catch (error) {
        console.error('Logout failed:', error);
      }
    };

    return {
      isAuthenticated,
      logout,
    };
  },
};
</script>

<style scoped>
  header {
    background-color: #f8f8f8;
    padding: 1rem;
    border-bottom: 1px solid #ddd;
  }
  
  nav ul {
    list-style-type: none;
    padding: 0;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
  }
  
  nav a {
    text-decoration: none;
    color: #333;
  }
  
  nav a:hover {
    text-decoration: underline;
  }

  .logout__link {
    cursor: pointer;
    text-decoration: none;
  }

  .logout__link:hover {
    text-decoration: underline;
  }
  </style>