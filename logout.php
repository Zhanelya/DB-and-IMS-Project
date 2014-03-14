<?php
    session_start();
    if (isset($_SESSION['userid'])) {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600);
        }
        session_destroy();
    }
    setcookie('userid', '', time() - 3600);
    setcookie('username', '', time() - 3600);
    echo 'You have been successfully logged out';
?>
