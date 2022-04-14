FROM php:7-apache

# set PATH for Wordpress CLI
ENV PATH="~/.composer/vendor/bin:${PATH}"

# reduce APT noise
ENV DEBIAN_FRONTEND=noninteractive

# use proper shell
SHELL ["/bin/bash", "-c"]

# to avoid all too common aborts because of debian repo timeouts
RUN echo 'APT::Acquire::Retries "30";' > /etc/apt/apt.conf.d/80-retries

# upgrade package list and default packages
RUN apt-get -qq update
RUN apt-get -qq upgrade

# install npm nodesource repo
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -

# install php extension dependencies
RUN apt-get -qq install libmemcached-dev zlib1g-dev libpng-dev libonig-dev libtidy-dev

# install dependencies for WP-CLI aand tools
RUN apt-get -qq install git unzip vim mariadb-client zip jq nodejs

# clean up to reduce docker image size
RUN apt-get -qq autoremove

# install PHP extensions required
RUN bash -c "pecl install xdebug memcached &> /dev/null"
RUN bash -c "docker-php-ext-install -j64 gd mbstring mysqli pdo pdo_mysql tidy bcmath &> /dev/null"
RUN docker-php-ext-enable  memcached xdebug gd mbstring mysqli pdo pdo_mysql tidy bcmath

# enable apache modules
RUN a2enmod rewrite headers ext_filter expires

# create self-signed cert and enable SSL on apache
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/C=AT/ST=Vienna/L=Vienna/O=Security/OU=Development/CN=example.com"
RUN a2ensite default-ssl
RUN a2enmod ssl

# get composer binary from composer docker image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# override entrypoint
# copy entrypoint script
COPY init.sh /usr/local/bin/init.sh

# copy plugin fetch script
COPY get_plugin.sh /usr/local/bin/get_plugin.sh

# copy ngrok script
COPY ngrok.sh /usr/local/bin/ngrok.sh

# make scripts executable
RUN chmod +x /usr/local/bin/*.sh

# override default entrypoin with ours
ENTRYPOINT [ "init.sh" ]

# add user and dir for executing composer
RUN useradd -u 431 -r -g www-data -s /sbin/nologin -c "Wordpress user" wp
RUN mkdir -p /home/wp && chown -R wp:www-data /home/wp /etc/ssl
USER wp
WORKDIR /home/wp

# install ngrok
COPY --from=ngrok/ngrok:debian /bin/ngrok /usr/bin/ngrok

# install WP-CLI and recommended packages
RUN composer global require wp-cli/wp-cli-bundle
RUN composer global require --dev $(composer suggests --by-package | awk '/wp-cli\/wp-cli-bundle/' RS= | grep -o -P '(?<=- ).*(?=:)')

RUN mkdir /tmp/wp-data
WORKDIR /tmp/wp-data

# download latest stable Wordpress
RUN wp core download

WORKDIR /var/www/html

EXPOSE 80
EXPOSE 443
