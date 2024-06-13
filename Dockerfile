# FROM php:8.2 as php

# Set the platform to linux/amd64
FROM --platform=linux/amd64 php:8.2 as php


# Install dependencies
RUN apt-get update -y
RUN apt-get  install -y unzip libpq-dev libcurl4-gnutls-dev supervisor
RUN docker-php-ext-install pdo pdo_mysql bcmath

#install redis and enable it on docker
RUN pecl install -o -f redis \
    && rm -f /temp/pear \
    && docker-php-ext-enable redis


#copy project files into the server
WORKDIR /var/www
COPY . .  

# Copy supervisor configuration
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# install composer
COPY --from=composer:2.6.5 /usr/bin/composer /usr/bin/composer

#set port variable
ENV PORT=8000

# expose port 8000
EXPOSE 8000

#define an entry point to run scripts
ENTRYPOINT [ "docker/entrypoint.sh" ]

# ==================================================
# node service

# FROM node:20-alpine as node

# Set the platform to linux/amd64 for node service
FROM --platform=linux/amd64 node:20-alpine as node

#copy project files into the server
WORKDIR /var/www
COPY . .  

RUN npm install --global cross-env
RUN npm install

VOLUME /var/www/node_modules

