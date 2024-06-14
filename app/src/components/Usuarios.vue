<template>
    <div>
      <h1>Gestão de Funcionários</h1>
      <ul>
        <li v-for="funcionario in funcionarios" :key="funcionario.id">
          {{ funcionario.name }} - {{ funcionario.email }}
          <button @click="deleteFuncionario(funcionario.id)">Excluir</button>
        </li>
      </ul>
      <form @submit.prevent="addFuncionario">
        <div>
          <label for="name">Nome</label>
          <input type="text" v-model="newFuncionario.name" required />
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" v-model="newFuncionario.email" required />
        </div>
        <div>
          <label for="password">Senha</label>
          <input type="password" v-model="newFuncionario.password" required />
        </div>
        <button type="submit">Adicionar Funcionário</button>
      </form>
    </div>
  </template>
  
  <script>
  import apiClient from '../services/api';
  
  export default {
    data() {
      return {
        funcionarios: [],
        newFuncionario: {
          name: '',
          email: '',
          password: '',
        },
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
      addFuncionario() {
        apiClient.post('/users', this.newFuncionario, {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
        })
          .then(() => {
            this.fetchFuncionarios();
          })
          .catch(error => {
            console.error('Erro ao adicionar funcionário:', error);
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
      }
    }
  };
  </script>
  