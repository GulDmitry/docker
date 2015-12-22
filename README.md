docker
======

To run a project go to <project>/src directory and run:

`docker-compose up`

A folder <project>/ext contains extended images that require built base images,
for example php `lamp/images/ext/php5.6-apache/Dockerfile` is based on `php:5.6-apache` base image (FROM clause),
to build it need to execute:

`docker build -t php:5.6-apache --force-rm=true .`

in the `lamp/images/base/php-<hash>/5.6/apache` directory.

TODO:
