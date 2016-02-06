<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$server="ap-cdbr-azure-southeast-b.cloudapp.net";

$database="forumdb";

$username="b53a04417753d1";

$password="c4ba95dc";

$connect=mysql_connect($server, $username, $password) or die("Could not connect to the server!");

mysql_selectdb($database,$connect) or die("Couldn't connect to the database : $database");

    
?>