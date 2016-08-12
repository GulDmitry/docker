<?php
require_once 'vendor/autoload.php';

use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\Authentication\Provider\LdapBindAuthenticationProvider;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;
use Symfony\Component\Security\Core\User\LdapUserProvider;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/*
 As an authentication mechanism:

 # app/config/security.yml
security:
    # ...

firewalls:
    api:
        provider:  app_users
        stateless: true
        pattern:   ^/api
        http_basic_ldap:
            service: app.ldap
            dn_string: "{username}@example"
    backend:
        provider: app_users
        pattern:  ^/admin
        logout:
            path:   logout
            target: login
        form_login_ldap:
            service: app.ldap
            dn_string: CN={username},OU=Users,DC=example,DC=com
            check_path: login_check
            login_path: login
 */

$config = [
    'host' => 'localhost',
    'port' => 389,
];
$baseDn = 'dc=openldap,dc=com';

$adapter = new Adapter($config);
$adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);

$ldap = new Ldap($adapter);

// To use full DN string as a login, replace filter parameter.
// Use `cn` as uidKey, default is Active Directory specific.
$userProvider = new LdapUserProvider($ldap, $baseDn, 'cn=admin,ou=admins,' . $baseDn, 'admin', [], 'cn');

// Without the search DN string provider cannot perform search.
//$userProvider = new LdapUserProvider($ldap, 'dc=openldap,dc=com', null, null, [], 'cn');

$authProvider = new LdapBindAuthenticationProvider(
    $userProvider,
    new UserChecker(),
    'ldap',
    $ldap,
    'cn={username},ou=People,' . $baseDn, // Bind DN string.
    false
);

$authManager = new AuthenticationProviderManager([
    $authProvider,
]);

// To use DN as login the provider should be tuned.
$unAuthToken = new UsernamePasswordToken('user1', 'user1', 'ldap');

$token = $authManager->authenticate($unAuthToken);

$result = $token->isAuthenticated();

var_dump('Good!', $result);
