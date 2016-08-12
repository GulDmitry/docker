<?php
$host = 'localhost';
$port = 389; // See the docker-compose.yml

$dn = 'cn=admin,ou=admins,dc=openldap,dc=com';
$pass = 'admin';

$connection = ldap_connect($host, $port);

if (!$connection) {
    die('Count not connect to LDAP server.');
}

ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);

$bind = ldap_bind($connection, $dn, $pass);

if (!$bind) {
    die('Count not log in.');
}

$filter = 'objectClass=*';
$attributes = [
    'cn',
    'sn',
    'uid',
    'description',
];

// Search information about the user.
// To get all the information replace $dn with 'dc=openldap,dc=com'.
$sr = ldap_search($connection, $dn, $filter, $attributes);

$sResult = ldap_get_entries($connection, $sr);

var_dump('Good!', $sResult);
