<?php

//Couldn't test this logout hook as CLef can't call this on localhost .  
    require_once('config.php');
    require_once('utility.php');
    require_once('vendor/autoload.php');

    if(isset($_POST['logout_token'])) {

        \Clef\Clef::initialize(CLEF_ID, CLEF_SECRET);
        try {
            $clef_id = \Clef\Clef::get_logout_information($_POST["logout_token"]);

            require('classes/user.php');
            $user = new User( $config );

            if( isset($_SESSION['logged_in_at']) &&  ( $_SESSION['logged_in_at']< time() ) ){
                $user->update_user( array( 'id' => $_SESSION['user_id'] ) , array( 'last_signout' => addslashes(date("Y-m-d H:i:s"))  );
            }
            else{
                die("Couldn't logout properly.");
            }

            session_destroy();
            redirect('index.php');
        } catch (Exception $e) {
           die(json_encode(array('error' => $e->getMessage())));
        }
    }
?>
