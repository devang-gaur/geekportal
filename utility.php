<?php

define( 'YES' , 1 );

define( 'NO' , 0 );

define( 'ADMIN_USER' , 1);

define( 'USER' , 0);


function redirect($url)
{
    header('location:'.$url);
    exit();
}


?>