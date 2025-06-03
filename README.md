# Projeto Invocorp

Este é um projeto Laravel com Vue.js que utiliza o Laravel Sail para desenvolvimento em ambiente Docker.

## Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/)

## Instalação e Configuração

Siga os passos abaixo para configurar o projeto em seu ambiente local:

### 1. Clone o repositório
```bash
git clone git@github.com:ggemente/teste-invocorp-vue.git
cd teste-invocorp-vue
```

### 2. Instale as dependências do PHP
```bash
composer install
```

### 3. Configure o arquivo de ambiente
```bash
cp .env.example .env
```

### 4. Inicie os containers Docker
```bash
sail up -d
```

### 5. Instale as dependências do Node.js
```bash
sail npm install
```

### 6. Gere a chave da aplicação
```bash
sail artisan key:generate
```

### 7. Crie o link simbólico para storage
```bash
sail artisan storage:link
```

### 8. Execute as migrações do banco de dados
```bash
sail artisan migrate
```

### 9. Compile os assets do frontend
```bash
sail npm run build
```