# Weapon Management System

## Docker Commands

- Run with spark
```shell
docker run -it --rm --name run-wms-php74 -p 8080:8080 -v $PWD:/usr/src/myapp -w /usr/src/myapp php74-cli-intl php spark serve --host 0.0.0.0
```

## Docker Commands (Not Working for Now)
- Create network

```shell
docker network create my-network
```

- Create volume
```shell
docker volume create my-data
```

- Run & Config PHP
```shell
docker run -it --name my-php --network my-network --network-alias my-php -v $PWD:/var/www/weapon-management-system -w /var/www -d php:8.0.29-fpm-alpine
docker exec -it my-php sh
curl -sSLf -o /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions
chmod +x /usr/local/bin/install-php-extensions
install-php-extensions intl
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
cd /var/www/wms.test && composer install
```

- Run MySQL
```shell
docker run -it --name my-mysql --network my-network --network-alias my-mysql -p 3307:3306 -e MYSQL_ROOT_PASSWORD=secret -v my-data:/var/lib/mysql -d mysql:8.0.34
```

- Run & Config Nginx
```shell
docker run -it --name my-nginx --network my-network --network-alias my-nginx -v $PWD:/var/www/wms.test -p 80:80 -w /var/www -d nginx:1.25.1-alpine
docker exec -it my-nginx sh
cp wms.test/wms.test.conf /etc/nginx/conf.d/
nginx -s reload
```