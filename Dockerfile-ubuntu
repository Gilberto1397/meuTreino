# Imagem ubuntu para criação de container com o necessário para rodar PHP 8.1 e Apache
# Junto de Node.js, NPM e Composer

FROM php:8.1.33-apache

LABEL authors="GilbertoJr"

WORKDIR /var/www/html/projetos/meu-treino

EXPOSE 80

# Atualizar repositórios e instalar dependências básicas
RUN apt-get upgrade
RUN apt-get update -y
RUN apt-get install -y vim git unzip

# Atualizar repositórios novamente
#RUN apt-get upgrade && apt-get update -y

# Limpar cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get autoremove -y

#Instalação do Node.js e NPM via NVM
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash

#Instalação do Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'ed0feb545ba87161262f2d45a633e34f591ebb3381f2e0063c345ebea4d228dd0043083717770234ec00c5a9f9593792') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
