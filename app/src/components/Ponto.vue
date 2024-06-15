<template>
  <div class="container">
    <div class="ponto-container">
      <h1>Registro de Ponto</h1>
      <div class="ponto-data">
        <p>{{ currentDayOfWeek }} - {{ currentDate }} - {{ currentTime }}</p>
      </div>
      <div class="ponto-button">
        <button class="ponto-entrada" @click="baterPonto('entrada')">Entrada</button>
        <button class="ponto-saida" @click="baterPonto('saida')">Saída</button>
      </div>
    </div>
    <h2>Registros</h2>
    <table class="registros-tabela">
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
        <tr v-for="registro in registros.data" :key="registro.id">
          <td>{{ getDiaSemana(registro.entrada) }}</td>
          <td>{{ formatarData(registro.entrada) }}</td>
          <td>{{ formatarHora(registro.entrada) }}</td>
          <td>{{ formatarHora(registro.saida) }}</td>
          <td>{{ calcularHorasTrabalhadas(registro.entrada, registro.saida) }}</td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <button v-if="registros.prev_page_url" @click="carregarPagina(registros.current_page - 1)">Anterior</button>
      <button v-if="registros.next_page_url" @click="carregarPagina(registros.current_page + 1)">Próximo</button>
    </div>
  </div>
</template>

<script>
import apiClient from '../services/api';

export default {
  data() {
    return {
      registros: {},
      currentDate: '',
      currentTime: '',
      currentDayOfWeek: '',
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
    fetchRegistros(page = 1) {
      apiClient.get(`/registros?page=${page}`, {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
      })
        .then(response => {
          this.registros = response.data;
        })
        .catch(error => {
          console.error('Erro ao buscar registros:', error);
        });
    },
    carregarPagina(page) {
      this.fetchRegistros(page);
    },
    updateCurrentDateTime() {
      const now = new Date();
      const days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
      this.currentDate = now.toLocaleDateString('pt-BR');
      this.currentTime = now.toLocaleTimeString('pt-BR');
      this.currentDayOfWeek = days[now.getDay()];
    },
    formatarData(timestamp) {
      if (!timestamp) return '';
      const date = new Date(timestamp);
      return date.toLocaleDateString('pt-BR');
    },
    formatarHora(timestamp) {
      if (!timestamp) return '';
      const date = new Date(timestamp);
      return date.toLocaleTimeString('pt-BR');
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

      const hours = Math.floor(diffHrs);
      const minutes = Math.floor((diffHrs - hours) * 60);

      return `${hours > 0 ? hours + ' horas ' : ''}${minutes} minutos`;
    }
  }
};
</script>

<style>
.container {
    width: 80%;
    margin: 0 auto;
    text-align: center;
    padding-bottom: 60px; /* Espaço extra para o footer */
    display: flex;
    flex-direction: column;
}

.ponto-container {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.ponto-data {
  font-size: 36px;
}

.ponto-button {
  display: flex;
  margin: 0 auto;
  gap: 2em;
  height: 50px;
}

.ponto-entrada {
  background-color: #06D001;
  color: #ffffff;
  border: none;
  width: 120px;
  font-size: 20px;
  cursor: pointer;
}

.ponto-entrada:hover {
  background-color: #9BEC00;
}

.ponto-saida {
  background-color: #C80036;
  color: #ffffff;
  border: none;
  width: 120px;
  font-size: 20px;
  cursor: pointer;
}

.ponto-saida:hover {
  background-color: #EE4E4E;
}

.registros-tabela {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.registros-tabela th,
  .registros-tabela td {
    border: 1px solid #ddd;
    padding: 8px;
  }

  .registros-tabela th {
    background-color: #4F709C;
    color: white;
  }

.pagination {
  margin-top: 20px;
}

.pagination button {
  background-color: #4F709C;
  color: white;
  border: none;
  padding: 10px 20px;
  margin: 0 5px;
  cursor: pointer;
}

.pagination button:hover {
  background-color: #344e74;
}
</style>




  