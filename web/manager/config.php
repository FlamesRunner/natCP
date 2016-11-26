<?php
$sql_user = 'user'; // sql username
$sql_pass = 'password'; // sql password
DEFINE('NODE_IP', '192.168.9.2'); // nat container node
DEFINE('NODE_IPV6', '2001:0db8:85a3:0000:0000:8a2e:0370:'); // make sure you remove the contents before the last colon
DEFINE('NAT_PREFIX', '20'); // prefix for NAT ssh ports, in this case it is 20xxx
DEFINE('PRIV_IP_BLOCK', '192.168.4.'); // prefix for private IP addresses
DEFINE('NODE_USERNAME', 'remote'); // remote node username (restrict it to sudo containermanager ONLY)
DEFINE('NODE_PASSWORD', 'password'); // remote node password
?>
