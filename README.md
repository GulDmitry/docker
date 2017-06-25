docker
======

#### Requirements
* [docker](https://docs.docker.com/) >= 1.10.0
  * `wget -qO- https://get.docker.com/ | sh`
* [docker-compose](https://docs.docker.com/compose/) >= 1.6.1

To run a project go to <project>/src directory and run:

`docker-compose up` or `docker-compose up --build` to rebuild containers (docker caches layers).

A folder <project>/ext contains extended images that require built base images,
for example php `lamp/images/ext/php5.6-apache/Dockerfile` is based on `php:5.6-apache` base image (FROM clause).
Because the image is placed in ofiicial hub it will be downloaded automatically, otherwise it should be build manually, for example:  
`docker build -t php-custom:5.6-apache --force-rm=true .`  
in a folder with `Dockerfile` inside.

Docker is a daemon, make sure it's running:

`sudo service docker start`

## Basic commands
Tuned Ubuntu image:

`sudo docker pull phusion/baseimage`

Get containers IPs:

`docker inspect {hash or service names} | grep IPAddress`

Go to container's shell, or execute a command inside container:

`docker exec -it 580b9e371f71 bash`  
`docker exec {container-name} php -v`

Run in the background:

`docker-compose up -d`  
`docker-compose logs`

List of containers:

`docker ps`  
`docker ps -a` - to see stopped containers.

Build and remove previous builds

`docker build -t php:5.4-apache --force-rm=true .`

RM all <none> containers:

`docker rmi -f $(docker images | grep "^<none>" | awk "{print $3}")f`

Stop\rm all containers:

`docker stop $(docker ps -a -q)`  
`docker rm $(docker ps -a -q)`

To show all ENV variables run:

`docker-compose run db env`

, where the "db" is a docker-compose.yml service.

To run the same services with a specific project name (by default dir name):

`docker-compose -f /var/www/docker/lamp/src/docker-compose.yml -p test up`  
`docker-compose run web db -d`

To stop and remove containers with their networks:

`docker-compose down`
Or

`docker-compose stop`  
`docker-compose rm -f`  
`docker-compose network rm {service_name}`

Remove all containers:
`docker rm `docker ps --no-trunc -aq``

Run container:
`docker run -it {container} /bin/bash`
`docker-compose run {service} /bin/bash`

[Monitoring](http://www.weave.works/products/weave-scope/).

Inside a container if you get "Error opening terminal: unknown." error exec:

`export TERM=xterm`

Rebuild a service with overridden one:

`docker-compose -f docker-compose.yml -f docker-compose.fpm.yml build sugar-base-web-php`

## Registry
`push`, `pull` and `tag` methods can be executed via `docker` command, the rest methods are supported by [HTTP API](https://docs.docker.com/registry/spec/api/).  
`curl -X GET http://registry/v2/_catalog` to retrieve a list of repositories in the registry.

#### Adding image
For example you want to add PHP 7.0 image to the registry based on official image.

First make a new `Dockerfile` to fill the image with custom stuff:
```
FROM php:7.0-apache # Official image, see https://hub.docker.com/_/php/

# Tune it
# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql

# ...

EXPOSE 80
CMD ["apache2-foreground"]
```

In the directory run `docker build -t php-custom:7.0-apache --force-rm=true .`

Run `docke images` and make sure the new image exist.
```
REPOSITORY               TAG                 IMAGE ID            CREATED             SIZE
php-custom               7.0-apache          8bab3dfe689c        14 seconds ago      563.6 MB
```

Tag the image to change its repository name:

`docker tag 8bab3dfe689c registry./username/php:7.0-apache`

> **Note**: This command does *not* affect the original image, just makes a copy with new repository name.

Now push the image to registry:

`docker push registry/username/php:7.0-apache`

Check the new tag in registry:
`curl -X GET http://registry/v2/username/php/tags/list`

#### Modifying image
Lets add a virtual host to the image created in the [Adding image](#adding-image).

Make a container from the image by `docker run registry/username/php:7.0-apache` or `docker-compose up`.

`docker ps` to make sure that container is running.
```
CONTAINER ID  IMAGE                                                   COMMAND               CREATED        STATUS        PORTS 
93046674cb61  registry/username/php:7.0-apache  "apache2-foreground"  3 seconds ago  Up 2 seconds  0.0.0.0:8081->80/
```

Copy a file with virtual host to the container

`docker cp sites-enabled/000-default.conf 93046674cb61:/etc/apache2/sites-enabled/000-default.conf`

Commit the changes:

`docker commit -m "Added virtual host." -a "User <email@ex.com>" 93046674cb61 registry/username/php:7.0-apache`

Push the image:

`docker push registry/username/php:7.0-apache`

##TODO:
