<template>
  <div class="login-container">
    <h1 class="login-titulo">Login</h1>
    <form class="login-formulario" @submit.prevent="login">
      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input class="form-input" type="email" v-model="form.email" required />
      </div>
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input class="form-input" type="password" v-model="form.password" required />
      </div>
      <button class="login-botao" type="submit">Entrar</button>
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

<style scoped>
    .login-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    border: 2px solid #4F709C;
    border-radius: 2px;
    padding: 2em;
    width: 30%;
    background-color: #F0F0F0;
    margin: auto; /* Centraliza horizontalmente */
  }

  .login-formulario {
    display: flex;
    flex-direction: column;

    width: 70%;
    gap: 1.5em;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
    
  }

  .form-label {
    margin-bottom: 0.5em;
    color: #213555;
  }

  .form-input {
    border: 2px solid #4F709C;
    border-radius: 5px;
    padding: 0.5em;
    width: 100%;
  }

  .form-botao {
    padding: 0.5em;
    background-color: #4F709C;
    color: #ffffff;
    border: none;
    width: 70%;
    margin: 0 auto;
    cursor: pointer;
  }

  .login-titulo {
    font-size: 30px;
    color: #4F709C; /* Define a cor do texto */
    padding-bottom: 0.5em; /* Adiciona um pouco de preenchimento na parte inferior */
  }

  .login-botao {
    padding: 0.5em;
    background-color: #4F709C;
    color: #ffffff;
    border: none;
    width: 70%;
    margin: 0 auto;
    cursor: pointer;
  }




</style>

  