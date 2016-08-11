# OpenLDAP and phpLDAPAdmin.

* [OpenLDAP box](https://github.com/osixia/docker-openldap).
* [phpLDAPAdmin box](https://github.com/osixia/docker-phpLDAPadmin).

## Getting Started
* Install [Docker](https://docs.docker.com/engine/installation/) and [Docker Compose](https://docs.docker.com/compose/install/).
* Go to /repository/openldap
* Run `docker-compose up`
  > *Note:* To avoid the  `ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?` error 
  use the `-d` (background process) - `docker-compose up -d`.
* To stop or remove containers made by `up` command run, in the `openldap` directory, `docker-compose stop` `docker-compose rm` commands respectively.

## Test Connection
* Docker:
  * `docker ps` - to show running containers.
  * `docker exec -t {openldap_container_id} ldapsearch -x -h localhost -b dc=openldap,dc=com -D "cn=admin,dc=openldap,dc=com" -w admin` - to search admin's data.
* Raw PHP
  * `php testConnection.php`
* Symfony LDAP
  *

## phpLDAPAdmin
* Go to http://localhost:8899
* Login(DN): `cn=admin,dc=openldap,dc=com`
* Password: `admin`
### Creating a new user
* (optional) Create a new group by clicking `Create new entry here`.
* Generic: Posix Group, enter a new for instance `users`.
* Create a child entry
* Generic: User Account
* User: test - test
* New DN is `cn=test,cn=users,dc=openldap,dc=com`
  * Test `docker exec -t {openldap_container_id} ldapsearch -x -h localhost -b dc=openldap,dc=com -D "cn=test,cn=users,dc=openldap,dc=com" -w test`

#TODO
* User fixtures.
