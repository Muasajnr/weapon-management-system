FROM php:7.4-cli

RUN curl -sSLf -o /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions
    
RUN chmod +x /usr/local/bin/install-php-extensions
    
RUN install-php-extensions intl mysqli