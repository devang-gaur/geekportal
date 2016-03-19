<?php

require_once('config.php');
require_once('utility.php');
require_once('vendor/autoload.php');

function validate_state($state) {
    $is_valid = isset($_SESSION['state']) && strlen($_SESSION['state']) > 0 && $_SESSION['state'] == $state;
    if (!$is_valid) {
        header('HTTP/1.0 403 Forbidden');
        echo "The state parameter didn't match what was passed in to the Clef button.";
        exit;
    } else {
        unset($_SESSION['state']);
    }
    return $is_valid;
}

if (!session_id()) {
    session_start();
}

if (isset($_GET["code"]) && $_GET["code"] != "") {
    validate_state($_GET["state"]);

    \Clef\Clef::initialize(CLEF_ID, CLEF_SECRET);
    try {
        $response = \Clef\Clef::get_login_information($_GET["code"]);
        $result = $response->info;
        // reset the user's session
        if (isset($result->id) && ($result->id != '')) {
            //remove all the variables in the session
            session_unset();
            // destroy the session
            session_destroy();

            if (!session_id())
                session_start();

            $clef_id = $result->id;
            $clef_email = $result->email;

            require_once('classes/user.php');

            $user = new User( $config );

            if($clef_users = $user->select_user( array( 'clef' => $clef_id ) ) ){
                // user already registered with clef
                $_SESSION['signed_in']=true;
                $_SESSION['user_name'] = $clef_users[0]['name'];
                $_SESSION['user_pass'] = $clef_users[0]['pass'];
                $_SESSION['user_id'] = $clef_users[0]['id'];
                $_SESSION['user_level'] = $clef_users[0]['level'];
                $_SESSION['user_dp'] = $clef_users[0]['dp'];
                $_SESSION['user_clef'] = $clef_users[0]['clef'];
                $_SESSION['logged_in_at'] = time();
                $user->update_user( array( 'email'=>$clef_email ), array( 'last_signin'=>addslashes(date("Y-m-d H:i:s")) ) );

                redirect("index.php");

            } else if( $clef_users = $user->select_user( array( 'email' => $clef_email ) ) ){
                //registered user but first time logging in with clef
                $user->update_user( array( 'email'=>$clef_email ), array( 'clef'=>$clef_id , 'last_signin'=>addslashes(date("Y-m-d H:i:s")) ) );

                $_SESSION['signed_in']=true;
                $_SESSION['user_name'] = $clef_users[0]['name'];
                $_SESSION['user_pass'] = $clef_users[0]['pass'];
                $_SESSION['user_id'] = $clef_users[0]['id'];
                $_SESSION['user_level'] = $clef_users[0]['level'];
                $_SESSION['user_dp'] = $clef_users[0]['dp'];
                $_SESSION['user_clef'] = $clef_id;
                $_SESSION['logged_in_at'] = time();
                redirect("index.php");

            } else{
                //user is completely new to the website .
                $_SESSION['pending_clef_id'] = $clef_id;
                $_SESSION['pending_clef_email'] = $clef_email;
                redirect("signup.php");
            }

        }
    } catch (Exception $e) {
       echo "Login with Clef failed: " . $e->getMessage();
    }
}
?>

