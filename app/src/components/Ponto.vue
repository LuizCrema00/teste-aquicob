<template>
  <div>
    <h1>Registro de Ponto</h1>
    <div>
      <p>{{ currentDate }} - {{ currentTime }}</p>
    </div>
    <button @click="baterPonto('entrada')">Bater Ponto de Entrada</button>
    <button @click="baterPonto('saida')">Bater Ponto de Saída</button>
    <h2>Registros</h2>
    <table>
      <thead>
        <tr>
          <th>Dia da Semana</th>
          <th>Data</th>
          <th>Entrada</th>
          <th>Saída</th>
          <th>Horas Trabalhadas</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="registro in registros" :key="registro.id">
          <td>{{ getDiaSemana(registro.entrada) }}</td>
          <td>{{ formatarData(registro.entrada) }}</td>
          <td>{{ formatarHora(registro.entrada) }}</td>
          <td>{{ formatarHora(registro.saida) }}</td>
          <td>{{ calcularHorasTrabalhadas(registro.entrada, registro.saida) }}</td>
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
      registros: [],
      currentDate: '',
      currentTime: '',
    };
  },
  created() {
    this.fetchRegistros();
    this.updateCurrentDateTime();
    setInterval(this.updateCurrentDateTime, 1000);
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
    },
    updateCurrentDateTime() {
      const now = new Date();
      this.currentDate = now.toLocaleDateString();
      this.currentTime = now.toLocaleTimeString();
    },
    formatarData(timestamp) {
      if (!timestamp) return '';
      const date = new Date(timestamp);
      return date.toLocaleDateString();
    },
    formatarHora(timestamp) {
      if (!timestamp) return '';
      const date = new Date(timestamp);
      return date.toLocaleTimeString();
    },
    getDiaSemana(timestamp) {
      if (!timestamp) return '';
      const days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
      const date = new Date(timestamp);
      return days[date.getDay()];
    },
    calcularHorasTrabalhadas(entrada, saida) {
      if (!entrada || !saida) return '';
      const entradaDate = new Date(entrada);
      const saidaDate = new Date(saida);
      const diffMs = saidaDate - entradaDate;
      const diffHrs = diffMs / (1000 * 60 * 60);
      return diffHrs.toFixed(2) + ' horas';
    }
  }
};
</script>

<style>
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
}
</style>

  