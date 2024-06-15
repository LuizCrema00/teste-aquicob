# CRUD Supermercados

Sistema Ponto para controle de entradas e saídas de funcionario


### Build do Sistema

Siga os passos abaixo para configurar e executar o projeto localmente:

1. **Clonar o Repositório:**

   git clone https://github.com/LuizCrema00/teste-aquicob

2. ### Navegar entre pastas
   para a backend: cd api
   
   para o frontend: cd app

# BACKEND

1. ### Requisitos

- PHP 8.1 ou superior
- Composer 2.2 ou superior
- O projeto está no Laravel na versao 10.48.12

2. ### Instalação de Dependências

   composer install
   
   npm install
   
3. ### Configuração do Ambiente
    cp .env.example .env

   Copie o arquivo .env.example para .env e configure as variáveis de ambiente, como conexão com banco de dados.


4. ### Migrations e seeders

   php artisan migrate


6. ### Execução do projeto
   php artisan serve

   o projeto estará disponivel em http://localhost:8000 que é a porta padrao

# FRONTEND

1. ### Requisitos

- NPM 7 ou superior
- Node 18 ou superior
- O projeto esta utilizando vite na versão 5.2 com template vue na versão 3.4

2. ### Instalação de Dependências
   
   npm install

3. ### Execução do projeto

   npm run dev

   o projeto estará disponível em http://localhost:5173
