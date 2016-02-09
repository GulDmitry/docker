<?php
// Get DB service IP:
// getenv('DB_PORT_3306_TCP_ADDR');
// docker inspect -f "{{ .NetworkSettings.IPAddress }}" src_db_1
// 172.17.0.2

// To debug set remove host to 172.17.42.1 (default docker IP)
// and setup Settings->PHP->servers to map url and local<->remote paths.

//$mysqli = new mysqli(getenv('DB_PORT_3306_TCP_ADDR'), 'root', 'root', 'sugarcrm');

var_dump(['xdebug', 'test']);
phpinfo();
