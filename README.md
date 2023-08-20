# Weapon Management System

# Docker Commands

- Run with spark
```shell
docker build . -t ci4-php74-cli
docker run -it --rm --name run-wms-php74 --network my-network -p 8080:8080 -v $PWD:/usr/src/myapp -w /usr/src/myapp ci4-php74-cli php spark serve --host 0.0.0.0
docker exec -it run-wms-php74 php spark migrate
```