<?php
include 'header.php';
include 'connect.php';

function redirect($url)
{
    header('location:'.$url);
    exit();
}
unset ($_SESSION['signed_in']);
session_destroy();
echo "you successfully signed out";
mysql_close($con);
redirect("index.php");
include 'footer.php';
?>