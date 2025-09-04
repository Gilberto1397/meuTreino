# Meu Treino

Este projeto é uma aplicação web para gerenciamento de treinos, composta por um back-end em Laravel (PHP) e um front-end em Vue.js. O objetivo é permitir o cadastro, organização e acompanhamento de exercícios físicos de forma simples e eficiente.

## Estrutura do Projeto
- **backEnd/**: API RESTful desenvolvida em Laravel.
- **frontEnd/**: Interface do usuário desenvolvida em Vue.js.

---

## Como rodar o projeto

### Pré-requisitos
- Docker instalado **ou** ambiente com PHP 7.4+, Composer, Node.js e npm/yarn
- Git

---

## Ambiente de Desenvolvimento

### 1. Instalar dependências manualmente (sem Docker)
#### Back-end (Laravel)
```bash
  cd backEnd
  composer install
  cp .env.example .env
  php artisan key:generate
  php artisan migrate
  php artisan serve
```

#### Front-end (Vue.js)
```bash
  cd frontEnd
  npm install
  npm run dev
```

---

## Ambiente de Produção

### 1. Build do front-end
```bash
  cd frontEnd
  npm install
  npm run build
```

### 2. Configuração do back-end
```bash
  cd backEnd
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan config:cache
  php artisan route:cache
  php artisan cache:clear
```

---

## Observações
- Para desenvolvimento, use `php artisan serve` e `npm run dev`.
- Para produção, utilize um servidor web real (Nginx/Apache) e rode o front-end em modo build.
- Recomenda-se o uso de Docker para facilitar o setup e garantir compatibilidade.

