FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

#RUN  --mount=type=cache,id=composer,target=/root/.composer composer update -v --no-dev && rm -rf .git
RUN composer update -v --no-dev

#CMD [ "php", "./public/index.php" ]
