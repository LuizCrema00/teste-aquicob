<template>
    <div>
      <h1>Registro de Ponto</h1>
      <button @click="baterPonto('entrada')">Bater Ponto de Entrada</button>
      <button @click="baterPonto('saida')">Bater Ponto de Saída</button>
      <h2>Registros</h2>
      <ul>
        <li v-for="registro in registros" :key="registro.id">
          Entrada: {{ registro.entrada }} | Saída: {{ registro.saida }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import apiClient from '../services/api';
  
  export default {
    data() {
      return {
        registros: [],
      };
    },
    created() {
      this.fetchRegistros();
    },
    methods: {
      baterPonto(tipo) {
        apiClient.post('/registros', { tipo }, {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
        })
          .then(response => {
            this.fetchRegistros();
            alert(response.data.message + ' - ' + response.data.timestamp);
          })
          .catch(error => {
            console.error('Erro ao bater ponto:', error);
          });
      },
      fetchRegistros() {
        apiClient.get('/registros', {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
        })
          .then(response => {
            this.registros = response.data;
          })
          .catch(error => {
            console.error('Erro ao buscar registros:', error);
          });
      }
    }
  };
  </script>
  