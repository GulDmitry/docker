docker
======

#### Requirements
* docker-compose >= 1.6.1
* docker >= 1.10.0

To run a project go to <project>/src directory and run:

`docker-compose up`

A folder <project>/ext contains extended images that require built base images,
for example php `lamp/images/ext/php5.6-apache/Dockerfile` is based on `php:5.6-apache` base image (FROM clause),
to build it need to execute:

`docker build -t php:5.6-apache --force-rm=true .`

in the `lamp/images/base/php-<hash>/5.6/apache` directory.

## Tips
Tuned Ubuntu image:
`sudo docker pull phusion/baseimage`

Get containers IPs:
`docker inspect {hash or service names} | grep IPAddress`

SSH instead of 22 port forwarding:
`docker exec -it 580b9e371f71 bash`

Run in the background:
`docker-compose up -d`
`docker-compose logs`

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

To stop and remove containers with their networs:
`docker-compose down`
Or
`docker-compose stop`
`docker-compose rm -f`
`docker-compose network rm {service_name}`

Monitoring.
http://www.weave.works/products/weave-scope/

Inside a container if you get "Error opening terminal: unknown." error exec:
`export TERM=xterm`

Rebuild a service with overridden one:
`docker-compose -f docker-compose.yml -f docker-compose.fpm.yml build sugar-base-web-php`

##TODO:
