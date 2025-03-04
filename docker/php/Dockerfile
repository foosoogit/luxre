FROM php:8.3-fpm

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mysqli \
    && apt-get install -y libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype \
    && docker-php-ext-install -j$(nproc) gd
RUN echo "alias ll='ls -la'" >> ~/.bashrc && . ~/.bashrc
WORKDIR /var/www/html
