<!-- src/components/CadastroFuncionario.vue -->
<template>
  <div class="cadastrar-funcionario">
    <h2>Cadastrar Novo Funcionário</h2>
    <form class="formulario-funcionario" @submit.prevent="addFuncionario">
      <div class="form-group">
        <label class="form-label" for="name">Nome</label>
        <input class="form-input" type="text" v-model="form.name" required />
      </div>
      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input class="form-input" type="email" v-model="form.email" required />
      </div>
      <div class="form-group">
        <label class="form-label" for="password">Senha</label>
        <input class="form-input" type="password" v-model="form.password" required />
      </div>
      <div class="buttons">
        <button class="salvar-button"  type="submit">Salvar</button>
        <a class="cancelar-button" href="/usuarios">Cancelar</a>
      </div>
    </form>
  </div>
</template>

<script>
import apiClient from '../services/api';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
      },
    };
  },
  methods: {
    addFuncionario() {
      apiClient.post('/users', this.form, {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
      })
        .then(() => {
          this.$router.push('/usuarios');
        })
        .catch(error => {
          console.error('Erro ao adicionar funcionário:', error);
        });
    }
  }
};
</script>

<style scoped>
  .cadastrar-funcionario {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1em;
    width: 80%;
  }

  .formulario-funcionario {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1em;
    width: 80%;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    width: 50%;
  }

  .form-input {
    border: 2px solid #4F709C;
    border-radius: 5px;
    padding: 0.5em;
    width: 100%;
  }

  .buttons {
    display: flex;
    gap: 1em;
  }

  .salvar-button {
    padding: 0.5em;
    background-color: #4F709C;
    color: #ffffff;
    border: none;
    width: 100px;
    margin: 0 auto;
    cursor: pointer;
  }

  .salvar-button:hover {
    background-color: #213555;
  }

  .cancelar-button {
    border: 2px solid #C80036;
    background-color: #C80036;
    color: #ffffff;
    text-decoration: none;
    text-align: center;
    width: 100px;
  }

  .cancelar-button:hover {
    background-color: #FF0000;
  }
</style>
