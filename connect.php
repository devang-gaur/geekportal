<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$server=/*"localhost";//*/"ap-cdbr-azure-southeast-b.cloudapp.net";//geekportalforumdb

$database="forumdb";//forumdb

$username=/*"root";//*/"b53a04417753d1";//forumdb_admin

$password=/*"";//*/"c4ba95dc";//Qwerty@123

//$connect=mysql_connect($server, $username, $password) or die("Could not connect to the server!");

//mysql_selectdb($database,$connect) or die("Couldn't connect to the database : $database");


try{
    $connect = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $connect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}catch(Exception $e){
    die(var_dump($e));
}
    
?>