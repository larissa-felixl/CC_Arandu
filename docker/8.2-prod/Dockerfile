# =================================================================
# Estágio 1: Builder
# =================================================================
FROM php:8.2-fpm-alpine AS builder

WORKDIR /app

# Instala todas as dependências de build (incluindo zlib-dev)
RUN apk add --no-cache \
    git unzip zip curl \
    libpng-dev libzip-dev jpeg-dev freetype-dev oniguruma-dev libxml2-dev \
    zlib-dev \
    nodejs npm \
    autoconf \
    $PHPIZE_DEPS

# Instala as extensões PHP
RUN pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip exif pcntl bcmath soap xml

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia os arquivos de dependência
COPY composer.json composer.lock ./
#COPY package.json package-lock.json ./ #tava dando problema então eu comentei

# Copia todo o código da aplicação ANTES de instalar as dependências.
COPY . .

# Instala as dependências.
#RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader #DESABILITADO TEMPORARIAMENTE

#TODO: REMOVER APÓS TESTES
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
####################

#RUN npm ci #tava dando problema então eu comentei

# Compila os assets e otimiza a aplicação Laravel
#RUN npm run build #tava dando problema então eu comentei
# RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Ajusta as permissões
RUN chown -R www-data:www-data /app

# =================================================================
# Estágio 2: Final
# =================================================================
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Instala as dependências de RUNTIME, incluindo as libs para as extensões PHP
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    zlib \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    libxml2

# Copia as extensões PHP já compiladas do estágio builder
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
# Copia as configurações que ativam as extensões
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Copia os arquivos de configuração do ambiente
COPY ./docker/8.2-prod/php.ini /usr/local/etc/php/conf.d/99-laravel.ini
COPY ./docker/8.2-prod/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/8.2-prod/supervisord.conf /etc/supervisord.conf

# Copia a aplicação já construída
COPY --from=builder --chown=www-data:www-data /app .

# Cria o diretório de log para o Supervisor
RUN mkdir -p /var/log/supervisor \
    && chown -R www-data:www-data /var/log/supervisor

# Cria os diretórios temporários para o Nginx e ajusta as permissões.
# O usuário 'www-data' (definido no nginx.conf) precisa de permissão de escrita aqui.
RUN mkdir -p /var/lib/nginx/tmp /var/log/nginx \
    && chown -R www-data:www-data /var/lib/nginx /var/log/nginx

# Cria um diretório temporário para uploads dentro do storage.
RUN mkdir -p /var/www/html/storage/framework/tmp

# Ajusta as permissões das pastas de storage e cache para o Laravel poder escrever nelas.S
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
    
# Healthcheck para monitorar a saúde da aplicação
HEALTHCHECK --interval=30s --timeout=3s --start-period=15s --retries=3 \
    CMD curl -f -L http://localhost/api/health-check || exit 1


EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]