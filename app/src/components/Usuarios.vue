<!-- src/components/Usuarios.vue -->
<template>
  <div class="funcionarios-container">
    <h1>Gestão de Funcionários</h1>
    <button class="button-cadastrar-funcionario" @click="goToCadastro">Adicionar novo funcionário</button>
    <table class="funcionarios-tabela">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="funcionario in funcionarios" :key="funcionario.id">
          <td>{{ funcionario.name }}</td>
          <td>{{ funcionario.email }}</td>
          <td>
            <button class="button-excluir" @click="deleteFuncionario(funcionario.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import apiClient from '../services/api';

export default {
  data() {
    return {
      funcionarios: [],
    };
  },
  created() {
    this.fetchFuncionarios();
  },
  methods: {
    fetchFuncionarios() {
      apiClient.get('/users', {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
      })
        .then(response => {
          this.funcionarios = response.data;
        })
        .catch(error => {
          console.error('Erro ao buscar funcionários:', error);
        });
    },
    deleteFuncionario(id) {
      apiClient.delete(`/users/${id}`, {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
      })
        .then(() => {
          this.fetchFuncionarios();
        })
        .catch(error => {
          console.error('Erro ao excluir funcionário:', error);
        });
    },
    goToCadastro() {
      this.$router.push('/cadastro-funcionario');
    }
  }
};
</script>

<style>
  .funcionarios-container {
    width: 80%;
    margin: 0 auto;
    text-align: center;
    padding-bottom: 60px; /* Espaço extra para o footer */
    display: flex;
    flex-direction: column;
  }

  .button-cadastrar-funcionario{
    background-color: #3b568c;
    color: #ffffff;
    border: none;
    height: 40px;
    width: 170px;
    font-weight: bold;
    cursor: pointer;
  }

  .button-cadastrar-funcionario:hover {
    background-color: #213555;
  }

  .funcionarios-tabela {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  .funcionarios-tabela th,
  .funcionarios-tabela td {
    border: 1px solid #ddd;
    padding: 8px;
  }

  .funcionarios-tabela th {
    background-color: #4F709C;
    color: white;
  }

  .button-excluir {
    background-color: #C80036;
    margin: 5px;
    padding: 5px 10px;
    color: white;
    border: none;
    cursor: pointer;
  }

  .button-excluir:hover {
    background-color: #FF0000;
  }
</style>
