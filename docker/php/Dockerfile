FROM php:7.4.9-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data && \
    apt update && \
    apt install --no-install-recommends \
        unzip \
        libicu-dev \
        git -y && \
    apt -y autoremove && \
    apt -y autoclean

RUN a2enmod rewrite && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Build su-exec from sources
RUN curl https://codeload.github.com/ncopa/su-exec/zip/v0.2 --output /tmp/su-exec.zip && \
    unzip /tmp/su-exec.zip -d /tmp && \
    make -C /tmp/su-exec-0.2 && \
    cp /tmp/su-exec-0.2/su-exec /usr/local/bin/su-exec && \
    chmod +x /usr/local/bin/su-exec && \
    echo "Su-exec user: '$(su-exec www-data whoami)'" && \
    rm -rf /tmp/su-exec-0.2 && \
    rm -f /tmp/su-exec.zip

RUN docker-php-ext-install intl && docker-php-ext-enable opcache intl
RUN mkdir -p  /var/www/.composer \
    && chown www-data:www-data /var/www/.composer

COPY --from=composer:2.0.0-alpha2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_HOME /var/www/.composer
