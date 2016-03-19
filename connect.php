<?php

require_once('config.php');


$server = $config['server'];

$database = $config['db'];

$username = $config['user'];

$password = $config['pass'];

$connect=mysql_connect($server, $username, $password) or die("Could not connect to the server!");

mysql_selectdb($database,$connect) or die("Couldn't connect to the database :'.$database");

?>