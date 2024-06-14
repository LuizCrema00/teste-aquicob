<!-- src/components/Login.vue -->

<template>
  <div>
    <h1>Login</h1>
    <form @submit.prevent="login">
      <div>
        <label for="email">Email</label>
        <input type="email" v-model="form.email" required />
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" v-model="form.password" required />
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import apiClient from '../services/api';

export default {
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
    };
  },
  methods: {
    login() {
      apiClient.post('/login', this.form)
        .then(response => {
          const token = response.data;
          localStorage.setItem('token', token);

          apiClient.get('/user', {
            headers: { Authorization: `Bearer ${token}` }
          }).then(userResponse => {
            localStorage.setItem('role', userResponse.data.role);
            const role = userResponse.data.role;
            if (role === 'admin') {
              this.$router.push('/usuarios');
            } else {
              this.$router.push('/ponto');
            }
          });
        })
        .catch(error => {
          console.error('Erro ao fazer login:', error);
          alert('Login falhou. Verifique suas credenciais.');
        });
    }
  }
};
</script>

  