FROM nginx

ADD docker/config/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/PonyCoffee