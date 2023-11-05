FROM php:8.2 as php

# Actualiza e instala las dependencias necesarias
RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev

# Instala las extensiones necesarias
RUN docker-php-ext-install pdo bcmath pdo_pgsql

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia tu aplicación dentro del contenedor
COPY . .

# Copia Composer desde otra imagen
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

# Establece la variable de entorno para el puerto
ENV PORT=8000

# Establece el punto de entrada
ENTRYPOINT [ "docker/entrypoint.sh" ]

# ==============================================================================
#  node
FROM node:18.3-alpine as node

WORKDIR /var/www
COPY . .

RUN npm install --global cross-env
RUN npm install

VOLUME /var/www/node_modules

CMD [ "npm", "run", "dev" "--" "--host=0.0.0.0" ] 