<?php
include 'header.php';

if( !isset($_SESSION['user_id']) ){
    redirect('index.php');
}


include 'connect.php';

unset ($_SESSION['signed_in']);
session_unset();
session_destroy();

mysql_close($con);
redirect("index.php");

include 'footer.php';
?>