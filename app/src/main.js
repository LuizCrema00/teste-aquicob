// src/main.js

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import apiClient from './services/api.js'; // Importando o serviço Axios

const app = createApp(App);

app.config.globalProperties.$http = apiClient; // Adicionando Axios como propriedade global

app.use(router);

app.mount('#app');

