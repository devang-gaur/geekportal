<?php 

require_once('config.php');

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}


// Utility function to generate state parameter for CLEF redirect .
function generate_state_parameter() {

    if (isset($_SESSION['state'])) {
        return $_SESSION['state'];
    } else {
        $state = base64url_encode(openssl_random_pseudo_bytes(32));
        $_SESSION['state'] = $state;
        return $state;
    }
}


if (!session_id()) {
    session_start();
}


?>