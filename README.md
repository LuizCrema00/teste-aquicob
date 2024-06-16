# Sistema "Ponto"

Sistema de Ponto eletronico

O Sistema possui Autenticação, nele temos um usuário administrador do sistema que possui permissao de criação, visualização e exclusão de outros usuários que possuem "roles" de funcionário.

![image](https://github.com/LuizCrema00/teste-aquicob/assets/102314153/708bde50-6898-49e9-a383-315cb7d1c0f6)

Para o usuário autenticado como administrador do sistema, é exibida a tela de gestão de funcionários.

![image](https://github.com/LuizCrema00/teste-aquicob/assets/102314153/4fef2e8a-50d7-4d4b-a5fd-f31279207ed8)

Para o usuário autenticado como funcionário, é exibida a tela de ponto eletronico. Em que é possivel realizar a entrada e a saída e obter os registros do dia, hora de chegada, hora de saída e quantidade de horas trabalhadas.

![image](https://github.com/LuizCrema00/teste-aquicob/assets/102314153/10848575-c72d-4b28-ad0b-68b0b08b189b)

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

   Executar as migracoes para o banco de dados

   php artisan migrate

   Inserir o usuario admin no banco de dados

   php artisan db:seed

   Com isso sera criado o usuario com

   Nome:admin

   Email:admin@admin.com

   Senha:admin

6. ### Execução do projeto

   para rodar o backend
   
   php artisan serve


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
