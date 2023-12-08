<?php

// Re-enter the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
    header("location: login.php?msg={$msg}");
    exit;
}

header("location: login.php?msg=Logged out!");
exit;

?>