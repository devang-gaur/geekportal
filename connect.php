<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$server="localhost";

$database="forumdb";

$username="root";

$password="";

$connect=mysql_connect($server, $username, $password) or die("Could not connect to the server!");

mysql_selectdb($database,$connect) or die("Couldn't connect to the database :'.$database");

    
?>