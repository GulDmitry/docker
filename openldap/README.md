# OpenLDAP and phpLDAPAdmin.

* [OpenLDAP box](https://github.com/osixia/docker-openldap).
* [phpLDAPAdmin box](https://github.com/osixia/docker-phpLDAPadmin).

## Getting Started
* Install [Docker](https://docs.docker.com/engine/installation/) and [Docker Compose](https://docs.docker.com/compose/install/).
* Go to `.../repository/openldap`
* Run `docker-compose up`
  * > *Note:* To avoid the  `ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?` error 
  use the `-d` (background process) - `docker-compose up -d`.
* To stop or remove containers made by `up` command run, in the `openldap` directory, `docker-compose stop` `docker-compose rm` commands respectively.

## Test Connection
* Docker:
  * `docker ps` - to show running containers.
  * `docker exec -t openldap ldapsearch -x -h localhost -b dc=openldap,dc=com -D "cn=admin,dc=openldap,dc=com" -w admin` - to search admin's data.
  The `openldap` name is defined in the compose file.
  * Make sure the result object does *not* look like `result: 32 No such object`.
* PHP
  * `php test/connect-raw.php` - raw PHP.
  * `php test/connect-symfony.php` - Symfony. Run `php composer.phar install -d 'test'` first.
  * `php test/auth-symfony.php` - Authenticate the demo user via Symfony.

## phpLDAPAdmin
* Go to [http://localhost:8899](http://localhost:8899)
* Login(DN): `cn=admin,dc=openldap,dc=com`
* Password: `admin`

#### Importing demo users
* Log in the Admin tool.
* Click `Import` button.
* Select `users.ldif` file.
* Test the group `docker exec -t openldap ldapsearch -x -h localhost -b ou=people,dc=openldap,dc=com -D "cn=admin,dc=openldap,dc=com" -w admin` 

#### Creating a new user manually
* Create a new organization `People` by clicking `Create new entry here` and selection `Organisational Unit`.
* Create a child group `users` by clicking `Create a child entry` - `Posix Group`.
* Create a child `User Account`: test - test.
* The final DN should be `cn=test,ou=People,dc=openldap,dc=com`
* Test `docker exec -t openldap ldapsearch -x -h localhost -b cn=test,ou=People,dc=openldap,dc=com -D "cn=test,ou=People,dc=openldap,dc=com" -w test`

#TODO
