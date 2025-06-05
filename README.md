# Instruções para Configurar e Rodar o Projeto Laravel com Sail (Docker-Only)

Este guia assume que você tem o Docker Desktop instalado e configurado para usar o WSL 2, e está em um terminal WSL.

1.  **Clone o Repositório:**
    ```bash
    cd laravel-12-project/
    ```

2.  **Copie o Arquivo de Ambiente:**
    ```bash
    cp .env.example .env
    ```
    *(Opcional: Revise o `.env` para configurações como `APP_PORT`)*

3.  **Instale as Dependências do Composer usando Docker:**
    (Isso instala o Laravel Sail e outras dependências PHP sem precisar de PHP/Composer no seu sistema host.)
    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist
    ```

4.  **Construa e Inicie os Contêineres do Sail:**
    ```bash
    ./vendor/bin/sail up -d --build
    ```
    *Aguarde alguns instantes para os serviços iniciarem.*

5.  **Gere a Chave da Aplicação e link simbólico para storage:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    
    ./vendor/bin/sail artisan storage:link
    ```

6.  **Execute as Migrations e Seeders:**
    ```bash
    ./vendor/bin/sail artisan migrate:fresh --seed --force
    ```

7.  **Instale as Dependências NPM:**
    ```bash
    ./vendor/bin/sail npm install
    ```

8.  **Construa os Assets NPM (para acesso inicial sem `npm run dev`):**
    ```bash
    ./vendor/bin/sail npm run build
    ```

9.  **Acesse a Aplicação:**
    Abra seu navegador e acesse `http://localhost` (ou a porta configurada em `APP_PORT` no seu `.env`).

10. **Para Desenvolvimento Frontend (opcional, em um novo terminal):**
    Se você for fazer alterações no CSS/JS e quiser recarregamento automático:
    ```bash
    ./vendor/bin/sail npm run dev
    ```

11. **Para Parar os Contêineres:**
    ```bash
    ./vendor/bin/sail down
    ```
