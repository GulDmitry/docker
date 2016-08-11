<?php
require_once 'vendor/autoload.php';

use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;

$config = [
    'host' => 'localhost',
    'port' => 389,
];
$dn = 'cn=admin,dc=openldap,dc=com';
$password = 'admin';

$adapter = new Adapter($config);
$adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);

$ldap = new Ldap($adapter);

$ldap->bind($dn, $password);

$filter = 'objectClass=*';
$attributes = [
    'cn',
    'sn',
    'uid',
    'description',
];

$query = $ldap->query($dn, 'objectClass=*', ['filter' => $attributes]);

$collection = $query->execute();

var_dump('Good!', $collection->toArray());
