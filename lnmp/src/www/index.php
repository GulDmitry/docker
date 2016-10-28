<?php
// Get DB service IP:
// getenv('DB_PORT_3306_TCP_ADDR');
// docker inspect -f "{{ .NetworkSettings.IPAddress }}" src_db_1
// 172.17.0.2

// To debug set remove host to 172.17.42.1 (default docker IP)
// and setup Settings->PHP->servers to map url and local<->remote paths.

//$mysqli = new mysqli(getenv('DB_PORT_3306_TCP_ADDR'), 'root', 'root', 'sugarcrm');

var_dump(['xdebug', 'works']);

$mysqli = mysqli_init();
$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0');
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);

if (!$mysqli->real_connect('172.16.238.10', 'root', 'root', 'testdb')) {
    die('Error ' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
var_dump('Db host info', $mysqli->host_info);
$mysqli->close();

phpinfo();
