# Meu Treino

Software desenvolvido para ajudar com a gestão de exercícios físicos. Se encontra ainda em desenvolvimento.

## Estrutura do Projeto
- **backEnd/**: API RESTful desenvolvida em Laravel.
- **frontEnd/**: Interface do usuário desenvolvida em Vue.js.
- **autenticacao/**: Módulo de autenticação utilizando JWT.

---

## Como rodar o projeto

### Pré-requisitos
- Docker instalado **ou** ambiente com PHP 7.4+ ou 8.1, Composer, Node.js e npm/yarn

---

## Ambiente de Desenvolvimento

### 1. Instalar dependências manualmente (sem Docker)
#### Back-end (Laravel)
```bash
  cd backEnd
  composer install
  cp .env.example .env
  php artisan key:generate
  php artisan jwt:secret
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

